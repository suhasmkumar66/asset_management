<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Log\Logger;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Http\Transformers\TicketsTransformer;
use App\Models\Ticket;
use DB;
use Auth;
use Log;
use Illuminate\Support\Facades\Route;
class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
         $url = url()->previous();
         $url_status = explode("/", $url);
         if($url_status[4] == 'open'){
             $search_status = "open";
         }
         else if($url_status[4] == 'assigned'){
             $search_status = "assigned";
         }
         else if($url_status[4] == 'closed'){
             $search_status = "closed";
         }
         else if($url_status[4] == 'acknowledged'){
             $search_status = "acknowledged";
         }
         else if($url_status[4] == 'inprogress'){
             $search_status = "inprogress";
         }
         else if($url_status[4] == 'index'){
             $search_status = "";
         }
         
//         if(url()->previous() == 'http://10.0.0.44:8080/tickets/open'){
//             Log::info('coming to open');
//         }
//         else{
//             Log::info(' not coming to open');
//         }
       
        $allowed_columns = ['id', 'ticket_id','name', 'priority_type','status','category_type', 'comment','company_id','department','wing_id','room_id','user_id'];
        // Admin
       if(Auth::user()->isSuperUser()){
           $tickets = Ticket::with( 'company','departments','wing','room','user');
           
       }
     
       //Agents
       else if(Auth::user()->isDepartment() == true){
           $tickets = Ticket::join('ticket_assign','ticket_assign.ticketId','=','tickets.id')
           ->where('ticket_assign.assigned_to', Auth::user()->id)
           ->orwhere('ticket_assign.coordinator', Auth::user()->id)
           ->orwhere('ticket_assign.collaborator', Auth::user()->id)
           ->with( 'company','departments','wing','room','user')->first();
           if($tickets == ''){
               $tickets = Ticket::where('user_id',Auth::user()->id)->with('company','departments','wing','room','user');
           }
     }
      // User Tickets
        else
       {
           $tickets = Ticket::where('created_to',Auth::user()->id)->with( 'company','departments','wing','room','user');
       }
       
       
        if ($request->filled('search')) {
            $tickets = $tickets->TextSearch($request->input('search'));
        }
        else{
            $tickets = $tickets->TextSearch($search_status);
        }
        
       
        
        if ($request->filled('company_id')) {
            $tickets->where('company_id','=',$request->input('company_id'));
        }
        if ($request->filled('department')) {
            $tickets->where('department','=',$request->input('department'));
        }
        if ($request->filled('wing_id')) {
            $tickets->where('wing_id','=',$request->input('wing_id'));
        }
        if ($request->filled('room_id')) {
            $tickets->where('room_id','=',$request->input('room_id'));
        }
        if ($request->filled('user_id')) {
            $tickets->where('user_id','=',$request->input('user_id'));
        }
        $offset = (($tickets) && (request('offset') > $tickets->count())) ? 0 : request('offset', 0);
        
        
        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');
        
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'id';
        $tickets->orderBy($sort, $order);
        $total = $tickets->count();
        $tickets = $tickets->skip($offset)->take($limit)->get();
        return (new TicketsTransformer)->transformTickets($tickets, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//      $this->authorize('create', Ticket::class);
        $ticket = new Ticket;
        $ticket->fill($request->all());
        
        if ($ticket->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $ticket, trans('admin/ticket/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $ticket->getErrors()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
