<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\AssetModel;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Models\User;
use Log;
use Carbon\Carbon;
use DB;
use DateTime;
/**
 * Model for Categories. Categories are a higher-level group
 * than Asset Models, and handle things like whether or not
 * to require acceptance from the user, whether or not to
 * send a EULA to the user, etc.
 *
 * @version    v1.0
 */

class Ticket extends AssetModel
{
    protected $presenter = 'App\Presenters\TicketPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'tickets';
    protected $hidden = ['user_id','deleted_at'];
    

    
    /**
     * Category validation rules
     */

//  
  
    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'user_id','created_to', 'first_name','employee_id', 'ticket_id', 'name', 'priority_type', 'comment', 'status','category_type','company_id','department','wing_id','room_id','extension','comment'
    ];
    
    public $rules = array(
        'user_id' => 'numeric|nullable',
        'first_name' => 'required|string|min:1',
        'employee_id' => 'required|string|min:1',
        'name'   => 'required|string|min:1',
        'category_type'   => 'required|string|min:1',
        'priority_type' => 'required|string|min:1',
        'company_id' => 'required|string|min:1',
        'department' => 'required|string|min:1',
        'extension' => 'required|string|min:1',
    );
    
    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['id','first_name','employee_id','name', 'ticket_id', 'status', 'category_type','company_id', 'department', 'extension'];
    
    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'company'      => ['name'],
        'user'   => ['first_name'],
        'departments' => ['name','building','floor'],
        'wing' => ['wing'],
        'room' => ['room_name']
    ];
    
    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }
    
    public function departments()
    {
        return $this->belongsTo('\App\Models\Department', 'department');
    }
    
    public function wing()
    {
        return $this->belongsTo('\App\Models\Wing', 'wing_id');
    }
    
    public function room()
    {
        return $this->belongsTo('\App\Models\Room', 'room_id');
    }
    
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
    
    public function assign(){
        return $this->belongsTo('App\Models\TicketAssign', 'id', 'ticketId');
    }
    
    public function getAssignedName($id){
       
        $assigned_agent = User::where('id',$id)->first();
        return $assigned_agent->first_name;
    }
    
    public function getHours($id){
      
        $logs = DB::table('ticket_logs')->where('ticketId',$id)->first();
        $start_time=$this->getStartTime($logs->ticketId);
        $end_time = $this->getEndTime($logs->ticketId);
        if($start_time != '' && $end_time!=''){
            $startTime = Carbon::parse($start_time);
            $finishTime = Carbon::parse($end_time );
            $totaldur = $finishTime->diffInSeconds($startTime);
            $total=  floor($totaldur / 3600) . gmdate(":i:s", $totaldur % 3600);
            return $total; 
			
        }
        else{
            $total = '';
            return $total;
        }
        
    }
    
    public function getStartTime($id){
        $inprogress = DB::table('ticket_logs')->where('ticketId',$id)->whereIn('status', ['inprogress'])->first();
        if(!empty($inprogress)){
            return $inprogress->created_at;
        }
        else{
            $empty = '';
            return $empty;
        }

    }
    
    public function getEndTime($id){
        $closed = DB::table('ticket_logs')->where('ticketId',$id)->where('status',['closed'])->first();
        if(!empty($closed)){
            return $closed->created_at;
        }
        else{
            $empty = '';
            return $empty;
        }

    }

    
    /**
     * scopeRequiresAcceptance
     *
     * @param $query
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@>
     * @version v1.0
     */
    public function scopeRequiresAcceptance($query)
    {
        
        return $query->where('require_acceptance', '=', true);
    }
    
}
