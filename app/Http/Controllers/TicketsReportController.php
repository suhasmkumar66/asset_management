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

class TicketsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('view', Ticket::class);
       
        $users=DB::table('users')->get();
        $company = DB::table('companies')->get();
        $category= Helper::ticketcategoryTypeList();
        
        return view('ticketreports/index')->with('users',$users)->with('company',$company)->with('category',$category);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,AppMailer $mailer)
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
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ticketId = null)
    {

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

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }

    
}
