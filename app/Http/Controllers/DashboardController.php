<?php
namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Models\Actionlog;
use View;
use Auth;
use Redirect;
use App\Models\Asset;
use App\Models\Company;

/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Asset-IT Asset Management application.
 *
 * @version    v1.0
 */
class DashboardController extends Controller
{
    /**
    * Check authorization and display admin dashboard, otherwise display
    * the user's checked-out assets.
    *
    * @author [Suhas M] [<Asset@Asset.net>]
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        if (Auth::user()->hasAccess('admin')) {

            $asset_stats=null;

            $counts['asset'] = \App\Models\Asset::count();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['ticket'] = \App\Models\Ticket::count();
            $counts['open_ticket'] = \App\Models\Ticket::where('status',"open")->count();
            $counts['assigned_ticket'] = \App\Models\Ticket::where('status',"assigned")->count();
            $counts['inprogress_ticket'] = \App\Models\Ticket::where('status',"inprogress")->count();
            $counts['closed_ticket'] = \App\Models\Ticket::where('status',"closed")->count();
            $counts['ack_ticket'] = \App\Models\Ticket::where('status',"acknowledged")->count();
            $counts['grand_total'] =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];

            if ((!file_exists(storage_path().'/oauth-private.key')) || (!file_exists(storage_path().'/oauth-public.key'))) {
                \Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('dashboard')->with('asset_stats', $asset_stats)->with('counts', $counts);
        } else {
        // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }
}
