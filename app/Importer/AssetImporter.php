<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\User;
use Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Auth;
class AssetImporter extends ItemImporter
{
    protected $defaultStatusLabelId;

    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->defaultStatusLabelId = Statuslabel::first()->id;
    }

    protected function handle($row)
    {

    
        // ItemImporter handles the general fetching.
        parent::handle($row);

        if ($this->customFields) {

            foreach ($this->customFields as $customField) {
                $customFieldValue = $this->array_smart_custom_field_fetch($row, $customField);

                if ($customFieldValue) {

                    if ($customField->field_encrypted == 1) {
                        $this->item['custom_fields'][$customField->db_column_name()] = \Crypt::encrypt($customFieldValue);
                        $this->log('Custom Field '. $customField->name.': '.\Crypt::encrypt($customFieldValue));
                    } else {
                        $this->item['custom_fields'][$customField->db_column_name()] = $customFieldValue;
                        $this->log('Custom Field '. $customField->name.': '.$customFieldValue);
                    }

                } else {
                    // Clear out previous data.
                    $this->item['custom_fields'][$customField->db_column_name()] = null;
                }
            }
        }


        $this->createAssetIfNotExists($row);
    }

    /**
     * Create the asset if it does not exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array $row
     * @return Asset|mixed|null
     */
    public function createAssetIfNotExists(array $row)
    {
        
        $editingAsset = false;
        $asset_tag_read = $this->findCsvMatch($row, "asset_tag");
        $department = $this->findCsvMatch($row, "department name");
        $building = $this->findCsvMatch($row, "building");
        $floor = $this->findCsvMatch($row, "floor");
        $wing = $this->findCsvMatch($row, "wing");
        $room_name = $this->findCsvMatch($row, "room name");
        $loc = $this->findCsvMatch($row, "location");
        $cat = $this->findCsvMatch($row, "category");
        $sl_no = $this->findCsvMatch($row, "sl_no");
        $company = $this->findCsvMatch($row, "company");
        $asset_no_tag=preg_replace('/[^0-9]/', '', $sl_no);
        if($cat == 'MONITOR' || $cat == 'Monitor'){
            $cat_string = 'D';
        }
        else{
            $cat_string = Str::substr($cat, 0, 1);
        }
        $asset_tag = $asset_tag_read.'-'.Str::substr($loc, 0, 3).'-'.strtoupper(Str::substr($floor, 0, 3)).'-'.strtoupper($wing).'-'.strtoupper(Str::substr($department, 0, 3)).'-'.strtoupper($cat_string).$asset_no_tag;
        $asset = Asset::where(['asset_tag'=> $asset_tag])->first();
        if ($asset) {
            if (!$this->updating) {
                $this->log('A matching Asset ' . $asset_tag . ' already exists');
                return;
            }

            $this->log("Updating Asset");
            $editingAsset = true;
        } else {
            $this->log("No Matching Asset, Creating a new one");
            $asset = new Asset;
        }

        $this->item['image'] = $this->findCsvMatch($row, "image");
        $this->item['warranty_months'] = intval($this->findCsvMatch($row, "warranty_months"));
        $this->item['model_id'] = $this->createOrFetchAssetModel($row);
        $this->item['company_id'] = $this->createOrFetchCompany($company);
        $this->item['status_id'] = '2';
        // If no status ID is found
//         if (!array_key_exists('status_id', $this->item) && !$editingAsset) {
//             $this->log("No status field found, defaulting to first status.");
//             $this->item['status_id'] = $this->defaultStatusLabelId;
//         }

        $this->item['asset_tag'] = $asset_tag;

        // We need to save the user if it exists so that we can checkout to user later.
        // Sanitizing the item will remove it.
        if(array_key_exists('checkout_target', $this->item)) {
            $target = $this->item['checkout_target'];
        }
        $item = $this->sanitizeItemForStoring($asset, $editingAsset);
        // The location id fetched by the csv reader is actually the rtd_location_id.
        // This will also set location_id, but then that will be overridden by the
        // checkout method if necessary below.
        if (isset($this->item["location_id"])) {
            $item['rtd_location_id'] = $this->item['location_id'];
        }
        
        $department_id = $this->createOrFetchDepartmentFrAsset($department,$building,$floor,$wing,$room_name);
        
        $hodname = $this->findCsvMatch($row, "hod name");
        $hodempid = $this->findCsvMatch($row, "hod emp id");
        $resname = $this->findCsvMatch($row, "responsible name");
        $resempid = $this->findCsvMatch($row, "responsible emp id");
        $hod_user_id = $this->createOrFetchHODFrAsset($hodname,$hodempid,$department_id);
        $res_user_id = $this->createOrFetchHODFrAsset($resname,$resempid,$department_id);
        $item['assigned_to'] = $res_user_id;
        if($res_user_id!= ''){
            $item['checkout_counter'] = '1';
            $item['assigned_type'] =  'App\Models\User';
            $item['last_checkout'] = Carbon::now('Asia/Kolkata');
        }
 
        $item['processor_type'] = $this->findCsvMatch($row, "processor type");
        $item['processor_speed'] = $this->findCsvMatch($row, "processor speed");
        $item['ram_type'] = $this->findCsvMatch($row, "ram type");
        $item['ram_1gb'] = $this->findCsvMatch($row, "ram -1 gb");
        $item['ram_2gb'] = $this->findCsvMatch($row, "ram-2 gb");
        $item['ram_3gb'] = $this->findCsvMatch($row, "ram-3 gb");
        $item['hdd_type'] = $this->findCsvMatch($row, "hdd type");
        $item['hdd_1gb'] = $this->findCsvMatch($row, "hdd -1 gb");
        $item['dvd'] = $this->findCsvMatch($row, "dvd");
        $item['os'] = $this->findCsvMatch($row, "os");
        $item['os_bit'] = $this->findCsvMatch($row, "os bit");
        $item['ms_office'] = $this->findCsvMatch($row, "ms office");
        $item['antivirus'] = $this->findCsvMatch($row, "antivirus");
        $item['av_status'] = $this->findCsvMatch($row, "av status");
        $item['mac_address'] = $this->findCsvMatch($row, "mac address");
        $item['end_username'] = $this->findCsvMatch($row, "end username");
        
        if ($editingAsset) {
            $asset->update($item);
        } else {
            $asset->fill($item);
        }

        // If we're updating, we don't want to overwrite old fields.
        if (array_key_exists('custom_fields', $this->item)) {
            foreach ($this->item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }

        //FIXME: this disables model validation.  Need to find a way to avoid double-logs without breaking everything.
        // $asset->unsetEventDispatcher();
        if ($asset->save()) {
            $asset->logCreate('Imported using csv importer');
            $this->log('Asset ' . $this->item["name"] . ' with serial number ' . $this->item['serial'] . ' was created');
            $action_log = DB::table('action_logs')->insert([
                'user_id' => Auth::user()->id,
                'action_type' => 'checkout to',
                'target_id' => $res_user_id,
                'target_type' => 'App\Models\User',
                'note' => 'Checked out on asset creation',
                'item_type' => 'App\Models\Asset',
                'item_id' => $asset->id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
            // If we have a target to checkout to, lets do so.
            if(isset($target)) {
                $asset->fresh()->checkOut($target);
            }
            return;
        }
        $this->logError($asset, 'Asset "' . $this->item['name'].'"');
    }
}
