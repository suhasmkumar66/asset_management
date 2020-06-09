<?php

namespace App\Http\Controllers;
use Log;
use Symfony\Component\HttpKernel\Log\Logger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Helpers\Helper;
use App\Models\Category as Category;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Setting;
use App\Models\User;
use App\Models\Department;
use App\Models\Wing;
use App\Mailers\AppMailer;
use Auth;
use DB;
use Illuminate\Support\Facades\Gate;
use Input;
use Lang;
use Redirect;
use Str;
use View;
use Mail;
use Image;
use App\Http\Requests\ImageUploadRequest;
use PhpParser\Builder\Function_;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//      $this->authorize('view', Ticket::class);
        return view('tickets/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//      $this->authorize('create', Category::class);
        $category_type= Helper::ticketcategoryTypeList();
        $priority_type= Helper::priorityTypeList();
        $department = DB::table('departments')->select('departments.id','departments.name','departments.building','departments.floor','wings.id as wing_id','wings.wing','rooms.room_name','rooms.id as room_id')
        ->leftjoin('wings','wings.department_id','=','departments.id')
        ->leftjoin('rooms','wings.department_id','=','departments.id')
        ->get();
        $ticket = new Ticket;
        return view('tickets/edit')->with('item', new Category)->with('ticket',$ticket)
        ->with('category_type', $category_type)->with('priority_type',$priority_type)->with('department',$department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,AppMailer $mailer)
    {


        if(!empty($request->input('employee_id'))){
            $employee_id = $request->input('employee_id');

            $users = DB::table('users')
            ->select('id','employee_num')
            ->where('employee_num',$employee_id)
            ->first();

            if(!empty($users)){
                $created_to = $users->id;
            }
            else{
                $created_to  = DB::table('users')->insertGetId([
                    'first_name'=>$request->input('first_name'),
                    'employee_num' => $employee_id

                ]);
            }
        }
        else{
            $created_to = Auth::id();
        }
//         if($request->input('name')!= '' && $request->input('department') && $request->input('first_name') && $request->input('employee_id') &&  $request->input('priority_type') && $request->input('company_id') && $request->input('category_type')){
        if($request->input('department') != ''){
            $department = explode("::", $request->input('department'));
            $department_id = $department[0];
            $wing_id = $department[1];
            $room_id = $department[2];
        }
        else{
            $department_id = '';
            $wing_id = '';
            $room_id = '';
        }

        $ticket = new Ticket;
        $ticket->name = $request->input('name');
        $ticket->first_name = $request->input('first_name');
        $ticket->employee_id = $request->input('employee_id');
        $ticket->priority_type = $request->input('priority_type');
        $ticket->company_id = $request->input('company_id');
        $ticket->comment = $request->input('comment');
        $ticket->status = "open";
        $ticket->user_id = Auth::id();
        $ticket->created_to = $created_to;
        $ticket->category_type = $request->input('category_type');
        $ticket->ticket_id = strtoupper(str_random(10));
        $ticket->department = $department_id;
        $ticket->wing_id = $wing_id;
        $ticket->room_id = $room_id;
        $ticket->extension = $request->input('extension');
        $ticket->created_at = Carbon::now('Asia/Kolkata');
        if ($ticket->save()) {
            //         $data = array();
            //         $data['name'] = e($request->input('name'));
            //         $data['priority_type'] = e($request->input('priority_type'));
            //         $data['status'] = e("open");
            //         //check config/mail configuration. not configured in .env file
            //          Mail::send('emails.ticket_info', $data, function ($m) use ($ticket) {
            //              $m->to("suhasmkumar66@", "IT" . ' ' . "Dalvkot");
            //              $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
            //              $m->subject("Ticket Created");
            //          });
            $user = DB::table('users')->where('id',Auth::user()->id)->first();

            $comment = $user->first_name.' created ticket to user '.$request->input('first_name') ;

            $ticket_log = DB::table('ticket_logs')->insertGetId([
                        'ticketId'=>$ticket->id,
                        'status' => "open",
                        'user_id'  =>Auth::id(),
                        'comments' => $comment,
                        'created_at' => Carbon::now('Asia/Kolkata')
                    ]);
            return redirect()->to('/tickets/index')->with('success', 'ticket created successfully');
            }
            return redirect()->back()->withInput()->withErrors($ticket->getErrors());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ticketId = null)
    {

//      $this->authorize('edit', Ticket::class);
        if (is_null($item = Ticket::find($ticketId))) {
            return redirect()->to('/tickets/index')->with('error', "ticket does not exist");
        }
        $category_type= Helper::ticketcategoryTypeList();
        $priority_type= Helper::priorityTypeList();
        $status = Helper::ticketStatusTypeList();
        $ticket = new Ticket;
        $department = DB::table('departments')->select('departments.id','departments.name','departments.building','departments.floor','wings.wing','rooms.room_name','wings.id as wing_id','rooms.id as room_id')
        ->leftjoin('wings','wings.department_id','=','departments.id')
        ->leftjoin('rooms','wings.department_id','=','departments.id')
        ->get();
        $wing = DB::table('wings')->select('wings.id as wing_id')->get();
        $room = Db::table('rooms')->select('rooms.id as room_id')->get();
        return view('tickets/edit', compact('item'))
        ->with('ticket',$ticket)
        ->with('category_type', $category_type)->with('priority_type',$priority_type)->with('department',$department)->with('wing',$wing)->with('room',$room)->with('status',$status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ticket = Ticket::find($id);
        if(!empty($request->input('employee_id'))){
            $employee_id = $request->input('employee_id');

            $users = DB::table('users')
            ->select('id')
            ->where('employee_num',$employee_id)
            ->first();

            if(!empty($users)){
                $created_to = $users->id;
            }
            else{
                $created_to  = DB::table('users')->insertGetId([
                    'first_name'=>$request->input('first_name'),
                    'employee_num' => $employee_id

                ]);
            }
        }
        else{
            $created_to = Auth::id();
        }
        $department = explode("::", $request->input('department'));
        $department_id = $department[0];
        $wing_id = $department[1];
        $room_id = $department[2];
        $ticket->first_name = $request->input('first_name');
        $ticket->employee_id = $request->input('employee_id');
        $ticket->name = $request->input('name');
        $ticket->company_id = $request->input('company_id');
        $ticket->priority_type = $request->input('priority_type');
        $ticket->comment = $request->input('comment');
        if(Auth::user()->isSelfAssigned($id) == true){
           $ticket->status = $request->input('status');
        }
        $ticket->user_id = Auth::id();
        $ticket->created_to = $created_to;
        $ticket->category_type = $request->input('category_type');
        $ticket->department = $department_id;
        $ticket->wing_id = $wing_id;
        $ticket->room_id = $room_id;
        $ticket->extension = $request->input('extension');
        $ticket->updated_at =Carbon::now('Asia/Kolkata');

        if($ticket->save()){
            if(Auth::user()->isSelfAssigned($id) == true){
                $status = $request->input('status');
            }
            else{
                $status = 'ticket edited';
            }
            $ticket_log = DB::table('ticket_logs')->insertGetId([
                'ticketId'=>$id,
                'status' => $status,
                'user_id'  =>Auth::id(),
                'comments' => "Ticket Updated By Admin",
                'created_at' => Carbon::now('Asia/Kolkata')
            ]);
            return redirect()->to('/tickets/index')->with('success', "Ticket updated");
        }
        return redirect()->back()->withInput()->withErrors($ticket->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//      $this->authorize('delete', Ticket::class);
       $ticket= DB::table('tickets')->where('id',$id)->delete();
       $ticket_assign =  DB::table('ticket_assign')->where('ticketId',$id)->delete();
       $ticket_log = DB::table('ticket_logs')->insertGetId([
           'ticketId'=>$id,
           'status' => "deleted",
           'user_id'  =>Auth::id(),
           'comments' => "Ticket deleted By Admin",
           'created_at' => Carbon::now('Asia/Kolkata')
       ]);
       return redirect()->to('/tickets/index')->with('success', "Ticket Deleted");
    }

    //assign tickets to agents
    public function getassign($id) {
        $ticket = DB::table('tickets')->find($id);
        $category_type= DB::table('users')->where('department_id' == 1);
        $ticket_assign = DB::table('ticket_assign')
        ->select('users.first_name','ticket_assign.created_at')
                    ->join('users','users.id','=','ticket_assign.assigned_to')
                    ->where('ticket_assign.ticketId',$id)
                    ->get();
        $ticket_coordinator = DB::table('ticket_assign')
        ->select('users.first_name')
                    ->join('users','users.id','=','ticket_assign.coordinator')
                    ->where('ticket_assign.ticketId',$id)
                    ->get();
        $ticket_collaborator = DB::table('ticket_assign')
                    ->select('users.first_name')
                    ->join('users','users.id','=','ticket_assign.collaborator')
                    ->where('ticket_assign.ticketId',$id)
                    ->get();
        $assigned_by = DB::table('ticket_assign')
                    ->select('users.first_name')
                    ->join('users','users.id','=','ticket_assign.assigned_by')
                    ->where('ticket_assign.ticketId',$id)
                    ->get();
        $ticket_coordinator=$ticket_coordinator->toArray();
        $ticket_collaborator = $ticket_collaborator->toArray();
        $assigned_by = $assigned_by->toArray();
        $results=array();
        $i = 1;
        foreach($ticket_assign as $key=>$data)
        {
            $newarr=array();
            $newarr['assigned_to']=$data->first_name;
            $newarr['created_at'] = $data->created_at;
            if(empty($ticket_coordinator) || empty($ticket_collaborator)){
                $newarr['coordinator'] = '-';
                $newarr['collaborator'] = '-';
            }
            else{
                $newarr['coordinator']=$ticket_coordinator[$key]->first_name;
                $newarr['collaborator']=$ticket_collaborator[$key]->first_name;
            }
            $newarr['assigned_by'] = $assigned_by[$key]->first_name;
            $newarr['slno'] = $i++;
            $results[]=$newarr;
        }
        return view('tickets/show')->with('item', new Category)
        ->with('ticket',$ticket)
        ->with('results',$results)
        ->with('category_type', $category_type);
    }

    public function postassign(Request $request,$id) {

        if(!empty($request->input('assigned_to'))){
            $checkfrstatus = DB::table('tickets')->where('id',$id)->first();
            $checkfrAssign = DB::table('ticket_assign')->where('ticketId',$id)->where('assigned_to',$request->input('assigned_to'))->first();
            if(empty($checkfrAssign)){
                $ticket_assign = DB::table('ticket_assign')->insertGetId([
                    'assigned_to'=>$request->input('assigned_to'),
                    'coordinator' => $request->input('coordinator'),
                    'collaborator' =>$request->input('collaborator'),
                    'ticketId' => $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'assigned_by' => Auth::id(),
                ]);
                $agent_name = DB::table('users')->where('id',$request->input('assigned_to'))->first();
                $user = DB::table('users')->where('id',Auth::user()->id)->first();
                $ticket_log = DB::table('ticket_logs')->insertGetId([
                    'ticketId'=>$id,
                    'status' => "assigned",
                    'user_id' =>Auth::id(),
                    'comments' => $user->first_name." Assigned ticket to agent ".$agent_name->first_name,
                    'created_at' => Carbon::now('Asia/Kolkata')
                ]);
                $ticket = DB::table('tickets')->where('id' ,$id)->update([
                    'status'=>"assigned",
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
                return redirect()->to('/tickets/index')
                ->with('success',' ticket assigned successfully');
            }
            else{
                if($checkfrstatus->status == 'acknowledged'){
                    $ticket_assign = DB::table('ticket_assign')->insertGetId([
                        'assigned_to'=>$request->input('assigned_to'),
                        'coordinator' => $request->input('coordinator'),
                        'collaborator' =>$request->input('collaborator'),
                        'ticketId' => $id,
                        'created_at' => Carbon::now('Asia/Kolkata'),
                        'assigned_by' => Auth::id(),
                    ]);
                    $ticket_log = DB::table('ticket_logs')->insertGetId([
                        'ticketId'=>$id,
                        'status' => "assigned",
                        'user_id' =>Auth::id(),
                        'comments' => "Assigned To Agents",
                        'created_at' => Carbon::now('Asia/Kolkata')
                    ]);
                    $ticket = DB::table('tickets')->where('id' ,$id)->update([
                        'status'=>"reopened",
                        'updated_at' => Carbon::now('Asia/Kolkata')
                    ]);
                    return redirect()->to('/tickets/index')
                    ->with('success',' ticket assigned successfully');
                }
                return redirect()->back()->withInput()->withErrors('ticket cannot be assigned to same person');
            }

        }

        else{
            return redirect()->back()->withInput()->withErrors('assign to is required');
        }

    }

    // Logs
    public function getLogs($id){
        $ticket = DB::table('tickets')->find($id);
        $ticket_logs = DB::table('ticket_logs')
        ->select('ticket_logs.status','ticket_logs.comments','users.first_name','ticket_logs.created_at','tickets.id')
        ->join('tickets','tickets.id','=','ticket_logs.ticketId')
        ->join('users','users.id','=','ticket_logs.user_id')
        ->where('ticket_logs.ticketId',$id)
        ->OrderBy('ticket_logs.id')
        ->get();

        $results=array();
        $i = 1;
        foreach($ticket_logs as $key=>$data)
        {
            $newarr=array();
            $newarr['status']=$data->status;
            $newarr['comments'] = $data->comments;
            $newarr['first_name']=$data->first_name;
            $newarr['created_at']=$data->created_at;
            $newarr['slno'] = $i++;
            $results[]=$newarr;
        }
        return view('tickets/ticketlogs')->with('item', new Category)
          ->with('ticket',$ticket)
        ->with('results',$results);

    }
    // accept ticket by agents
    public function getAccept($id){
        $ticket = DB::table('tickets')->find($id);
        return view('tickets/accept')->with('item', new Category)
        ->with('ticket', $ticket);
    }
    public function postAccept(Request $request,$id){
            $user = DB::table('users')->where('id',Auth::user()->id)->first();
            $comment = 'Ticket accepted by agent '.$user->first_name;

        $ticket_log = DB::table('ticket_logs')->insertGetId([
            'ticketId'=>$id,
            'status' => "inprogress",
            'user_id' =>Auth::id(),
            'comments' => $comment,
            'created_at' => Carbon::now('Asia/Kolkata')
        ]);
        $ticket = DB::table('tickets')->where('id' ,$id)->update([
            'status'=>"inprogress",
            'updated_at' => Carbon::now('Asia/Kolkata')
        ]);
        return redirect()->to('/tickets/index')
        ->with('success',' ticket accepted successfully');
    }

    //reject ticket by agents
    public function getReject($id){
        $ticket = DB::table('tickets')->find($id);
        return view('tickets/reject')->with('item', new Category)
        ->with('ticket',$ticket);
    }

    public function postReject(Request $request,$id){
        if(!empty($request->comment)){
            $ticket_log = DB::table('ticket_logs')->insertGetId([
                'ticketId'=>$id,
                'status' => "rejected",
                'user_id' =>Auth::id(),
                'comments' => $request->comment,
                'created_at' => Carbon::now('Asia/Kolkata')
            ]);
            $ticket = DB::table('tickets')->where('id' ,$id)->update([
                'status'=>"rejected",
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
            return redirect()->to('/tickets/index')
            ->with('success',' ticket rejected request considered');
        }

        else{
            return redirect()->back()->withInput()->withErrors('reason for reject is  required');
        }

    }

    //close ticket by agents
    public function getClose($id){
        $ticket = DB::table('tickets')->find($id);
        return view('tickets/close')->with('item', new Category)
        ->with('ticket',$ticket);
    }

    public function postClose(Request $request,$id){
        if(!empty($request->comment)){
            $user = DB::table('users')->where('id',Auth::user()->id)->first();
            $comment = 'Ticket closed by agent '.$user->first_name;
            $ticket_log = DB::table('ticket_logs')->insertGetId([
                'ticketId'=>$id,
                'status' => "closed",
                'user_id' =>Auth::id(),
                'comments' => $comment,
                'created_at' => Carbon::now('Asia/Kolkata')
            ]);
            $ticket = DB::table('tickets')->where('id' ,$id)->update([
                'status'=>"closed",
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
            return redirect()->to('/tickets/index')
            ->with('success',' ticket closed successfully');
        }
        else{
            return redirect()->back()->withInput()->withErrors('steps taken to solve ticket is required');
        }

    }

    // acknowledge ticket by users
    public function getAck($id){
        $ticket = DB::table('tickets')->find($id);
        return view('tickets/acknowledge')->with('item', new Category)
        ->with('ticket',$ticket);
    }

    public function postAck(Request $request,$id){
        if(!empty($request->comment)){
            $user = DB::table('users')->where('id',Auth::user()->id)->first();
            $comment = 'Ticket acknowledged by user '.$user->first_name;
            $ticket_log = DB::table('ticket_logs')->insertGetId([
                'ticketId'=>$id,
                'status' => "acknowledged",
                'user_id' =>Auth::id(),
                'comments' => $comment,
                'created_at' => Carbon::now('Asia/Kolkata')
            ]);
            $ticket = DB::table('tickets')->where('id' ,$id)->update([
                'status'=>"acknowledged",
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
            return redirect()->to('/tickets/index')
            ->with('success',' ticket acknowledged successfully');
        }
        else{
            return redirect()->back()->withInput()->withErrors('feedback for ticket is required');
        }

    }

    //transfer ticket by agents
    public function getTransfer($id){
        $ticket = DB::table('tickets')->find($id);
        return view('tickets/transfer')->with('item', new Category)
        ->with('ticket',$ticket);
    }

    public function postTransfer(Request $request,$id){
        if(!empty($request->comment)){
            $ticket_log = DB::table('ticket_logs')->insertGetId([
                'ticketId'=>$id,
                'status' => "transfered",
                'user_id' =>Auth::id(),
                'comments' => $request->comment,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ]);
            $ticket = DB::table('tickets')->where('id' ,$id)->update([
                'status'=>"transfered",
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
            return redirect()->to('/tickets/index')
            ->with('success',' ticket transfered');
        }
        else{
            return redirect()->back()->withInput()->withErrors('reason for ticket transfer is required');
        }

    }


}
