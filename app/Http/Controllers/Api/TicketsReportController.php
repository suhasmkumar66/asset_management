<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Log\Logger;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Http\Transformers\TicketsReportTransformer;
use App\Models\Ticket;
use DB;
use Auth;
use Log;
use Illuminate\Support\Facades\Route;
class TicketsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $url = url()->previous();
        $url_status = explode("?", $url);
        
        $company_url = $url_status[1];
        $company_id = explode("=", $company_url);
        
        $user_url = $url_status[2];
        $assignto_id = explode("=", $user_url);
        
        $type_url = $url_status[3];
        $cattype = explode("=", $type_url);
        
        $from_url = $url_status[4];
        $from =  explode("=", $from_url);
        
        $to_url = $url_status[5];
        $to = explode("=", $to_url);
       
        $assigned_to = $assignto_id[1];
        
        $allowed_columns = ['id', 'ticket_id','name', 'priority_type','status','category_type', 'comment','company_id','department','wing_id','room_id','user_id'];
            
            $tickets = Ticket::with( 'company','departments','wing','room','user','assign');
            // companies filtering
            if($company_id[0]== 'company' && $company_id[1]!= '%'){
                // return for company only
                $tickets=  $tickets->where('company_id','=',$company_id[1]);
                // return for company and user
                if($assignto_id[0] == 'user' && $assignto_id[1]!= '%'){
                    $tickets  = $tickets->whereHas('assign', function($q) use($assigned_to){
                        
                        $q->where('assigned_to', '=', $assigned_to);
                        
                    });
                        // return for company,user and type
                         if($cattype[0]== 'type' && $cattype[1]!= '%'){
                            $tickets=  $tickets->where('category_type','=',$cattype[1]);
                            
                            //return for company and user and type and date
                            if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                                $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                            }
                        }
                }
                // return for company and type
                else if($cattype[0]== 'type' && $cattype[1]!= '%'){
                    $tickets=  $tickets->where('category_type','=',$cattype[1]);
                    // company and type and date
                    if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                        $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                    }
                }
                // return for company and date
                else if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                    $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                }
            }//If ends here
            
            // users filtering
           else if($assignto_id[0] == 'user' && $assignto_id[1]!= '%'){
               // return for user only
                $tickets =Ticket::whereHas('assign', function($q) use($assigned_to){
                    
                    $q->where('assigned_to', '=', $assigned_to);
                    
                });
                    // return for user and type
                    if($cattype[0]== 'type' && $cattype[1]!= '%'){
                        $tickets=  $tickets->where('category_type','=',$cattype[1]);
                        
                        // return user and type and date range
                        if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                            $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                        }
                    }
                    // return for user and date range
                    else if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                        $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                    }
            }
            
            //category filtering
           else if($cattype[0]== 'type' && $cattype[1]!= '%'){
                // return for category only
                $tickets=  $tickets->where('category_type','=',$cattype[1]);
                // return for category and date
                if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                    $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
                }
            }
            
            //Date Filtering
            else if($from[0]== 'from' && $from[1]!= '%' && $to[0]== 'to' && $to[1]!= '%'){
                $tickets=  $tickets->whereDate('created_at','>=',$from[1])->whereDate('created_at','<=',$to[1]);
            }

            $tickets = $tickets->TextSearch($request->input('search'));
            
            
            
            $offset = (($tickets) && (request('offset') > $tickets->count())) ? 0 : request('offset', 0);
            
            
            // Check to make sure the limit is not higher than the max allowed
            ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');
            
            $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
            $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'id';
            $tickets->orderBy($sort, $order);
            $total = $tickets->count();
            $tickets = $tickets->skip($offset)->take($limit)->get();
            return (new TicketsReportTransformer)->transformTicketsReport($tickets, $total);
      
        

    
 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //      $this->authorize('create', Ticket::class);
       
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
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
    
    public function postFiltering(Request $request){
       
        $allowed_columns = ['id', 'ticket_id','name', 'priority_type','status','category_type', 'comment','company_id','department','wing_id','room_id','user_id'];
        // Admin
        
        $tickets = Ticket::with( 'company','departments','wing','room','user');
        $tickets = $tickets->TextSearch($request->input('search'));
        $offset = (($tickets) && (request('offset') > $tickets->count())) ? 0 : request('offset', 0);
        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'id';
        $tickets->orderBy($sort, $order);
        $total = $tickets->count();
        $tickets = $tickets->skip($offset)->take($limit)->get();
        return (new TicketsReportTransformer)->transformTicketsReport($tickets, $total);
        die;
        
    }
}
