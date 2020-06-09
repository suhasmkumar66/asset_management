<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Wing;
use App\Models\Room;
use App\Helpers\Helper;
use Auth;
use Image;
use App\Http\Requests\ImageUploadRequest;
use DB;
use Log;
class DepartmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the assets listing, which is generated in getDatatable.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @see AssetController::getDatatable() method that generates the JSON response
     * @since [v4.0]
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('index', Department::class);
        $company = null;
        if ($request->filled('company_id')) {
            $company = Company::find($request->input('company_id'));
        }
        return view('departments/index')->with('company', $company);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {

        $this->authorize('create', Department::class);
        $departmentcreate = new Department();
        $department = $request->input('name');
        $building = $request->input('building');
        $floor = $request->input('floor');
        $wing = $request->input('wing');
        $room_name = $request->input('room_name');
        $manager_id = ($request->filled('manager_id' ) ? $request->input('manager_id') : null);
        $user_id = Auth::user()->id;
        $extension_no = $request->input('extension_no');
        $location = ($request->filled('location_id' ) ? $request->input('location_id') : null);
        $company = ($request->filled('company_id' ) ? $request->input('company_id') : null);

            $departmentcheck = Department::where('name', '=', $department)->where('building', '=', $building)->where('floor', '=', $floor)->first();

            if($departmentcheck){

                $dept_id = $departmentcheck->id;
                if($wing!= ''){
                    $wingchek = Wing::where('department_id','=',$dept_id)->where('wing','=',$wing)->first();
                    if($wingchek){
                       Log::info('A matching Wing ' . $wing . ' to department' . $department . ' already exists');
                    }
                    else{
                        $wingcreate = new Wing();
                        $wingcreate->department_id = $dept_id;
                        $wingcreate->wing = $wing;
                        if($wingcreate->save()){
                            Log::info('Wing ' . $wing . ' to department ' . $department . '  was created');
                        }
                    }
                }
                if($room_name!= ''){
                    $roomchek = Room::where('department_id','=',$dept_id)->where('room_name','=',$room_name)->first();
                    if($roomchek){
                        Log::info('A matching room ' . $room_name . ' to department' . $department . ' already exists');
                    }
                    else{
                        $roomcreate = new Room();
                        $roomcreate->department_id = $dept_id;
                        $roomcreate->room_name = $room_name;
                        if($roomcreate->save()){
                            Log::info('Room ' . $room_name . ' to department ' . $department . '  was created');
                        }
                    }
                }
                return redirect()->route("departments.index")->with('success', trans('admin/departments/message.create.success'));
            }
            else{

                $departmentcreate->name = $department;
                $departmentcreate->building = $building;
                $departmentcreate->floor = $floor;
                $departmentcreate->extension_no = $extension_no;
                $departmentcreate->location_id = $location;
                $departmentcreate->company_id = $company;
                $departmentcreate->manager_id = $manager_id;
                $departmentcreate->user_id=$user_id;

                if ($departmentcreate->save()) {

                    Log::info('Department ' . $department . ' was created');
                    $dept_id = $departmentcreate->id;

                    if($wing!= ''){
                        $wingcreate = new Wing();
                        $wingcreate->department_id = $dept_id;
                        $wingcreate->wing = $wing;
                        if($wingcreate->save()){
                            Log::info('Wing ' . $wing . ' to department ' . $department . '  was created');
                        }

                    }
                    if($room_name!=''){
                        $roomcreate = new Room();
                        $roomcreate->department_id = $dept_id;
                        $roomcreate->room_name = $room_name;
                        if($roomcreate->save()){
                            Log::info('Room ' . $room_name . ' to department ' . $department . '  was created');
                        }

                    }
                    return redirect()->route("departments.index")->with('success', trans('admin/departments/message.create.success'));
                }
            }


        return redirect()->back()->withInput()->withErrors($departmentcreate->getErrors());


    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the department detail page.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @param int $id
     * @since [v4.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $department = Department::find($id);

        $this->authorize('view', $department);

        if (isset($department->id)) {
            return view('departments/view', compact('department'));
        }
        return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist', compact('id')));
    }


    /**
     * Returns a form view used to create a new department.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @see DepartmentsController::postCreate() method that validates and stores the data
     * @since [v4.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Department::class);

        $building= Helper::buildingTypeList();
        $floor= Helper::floorTypeList();
        $wing = Helper::wingTypeList();
        $department = new Department;
        $wingmodel = new Wing;
        $roommodel = new Room;
        $checkfrwing = '';
        $checkfrroom = '';
        return view('departments/edit')->with('item',$department)->with('department',$department)->with('checkfrwing',$checkfrwing)->with('checkfrroom',$checkfrroom)->with('wingmodel',$wingmodel)->with('roommodel',$roommodel)->with('building',$building)->with('floor',$floor)->with('wing',$wing);
    }


    /**
     * Validates and deletes selected department.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @param int $locationId
     * @since [v4.0]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (is_null($department = Department::find($id))) {
            return redirect()->to(route('departments.index'))->with('error', trans('admin/departments/message.not_found'));
        }

        $this->authorize('delete', $department);

        if ($department->users->count() > 0) {
            return redirect()->to(route('departments.index'))->with('error', trans('admin/departments/message.assoc_users'));
        }

        $department->delete();
        return redirect()->back()->with('success', trans('admin/departments/message.delete.success'));

    }

    /**
     * Makes a form view to edit location information.
     *
     * @author [Suhas M] [<Asset@Asset.net>]
     * @see LocationsController::postCreate() method that validates and stores
     * @param int $locationId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        if (is_null($item = Department::find($id))) {
            return redirect()->back()->with('error', trans('admin/locations/message.does_not_exist'));
        }

        $this->authorize('update', $item);
        $building= Helper::buildingTypeList();
        $floor= Helper::floorTypeList();
        $wing = Helper::wingTypeList();
        $department = new Department;
        $check =  Wing::where('department_id', $id)->first();
        if($check){
            $checkfrwing = $check->wing;
        }
        else{
            $checkfrwing = '';
        }

        $checkfrroom =  Room::where('department_id', $id)->first();
        if($checkfrroom){
            $checkfrroom =  $checkfrroom->room_name;
        }
        else{
            $checkfrroom =  '';
        }

        return view('departments/edit', compact('item'))
        ->with('department',$department)
        ->with('building',$building)->with('floor',$floor)->with('wing',$wing)->with('checkfrwing',$checkfrwing)->with('checkfrroom',$checkfrroom);
    }

    public function update(ImageUploadRequest $request, $id) {

        if (is_null($department = Department::find($id))) {
            return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist'));
        }

        $this->authorize('update', $department);

        $department->fill($request->all());
        $department->manager_id = ($request->filled('manager_id' ) ? $request->input('manager_id') : null);
        $department->building = $request->input('building');
        $department->floor = $request->input('floor');
        $department->extension_no = $request->input('extension_no');
        $department = $request->handleImages($department,600, public_path().'/uploads/departments');
        $wing = $request->input('wing');
        $room = $request->input('room_name');
        $roomvalue = $request->input('roomvalue');
        $wingvalue = $request->input('wingvalue');
        if ($department->save()) {
            if($wing!= ''){
                $wingcheck = DB::table('wings')->where('department_id' ,$id)->where('wing',$wingvalue)->first();
                if($wingcheck){
                    $wing_id = $wingcheck->id;
                    $wingupdate =  DB::table('wings')->where('id' ,$wing_id)->update([
                        'wing'=> $wing,
                        'updated_at' => Carbon::now('Asia/Kolkata')
                    ]);
                }
                else{
                    $wingcreate = new Wing();
                    $wingcreate->department_id = $id;
                    $wingcreate->wing = $wing;
                    if($wingcreate->save()){
                        Log::info('Wing   was created');
                    }
                }
            }
            if($room!= ''){
                $roomcheck = DB::table('rooms')->where('department_id' ,$id)->where('room_name',$roomvalue)->first();
                if($roomcheck){
                    $room_id = $roomcheck->id;
                    $roomupdate = DB::table('rooms')->where('id' ,$room_id)->update([
                          'room_name'=> $room,
                          'updated_at' => Carbon::now('Asia/Kolkata')
                       ]);
                }
                else{
                    $roomcreate = new Room();
                    $roomcreate->department_id = $id;
                    $roomcreate->room_name = $room;
                    if($roomcreate->save()){
                        Log::info('Room  was created');
                    }
                }
            }
            return redirect()->route("departments.index")->with('success', trans('admin/departments/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($department->getErrors());
    }
}
