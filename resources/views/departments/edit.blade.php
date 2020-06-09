@extends('layouts/edit-form', [
    'createText' => trans('admin/departments/table.create') ,
    'updateText' => trans('admin/departments/table.update'),
    'helpTitle' => trans('admin/departments/table.about_locations_title'),
    'helpText' => trans('admin/departments/table.about_locations'),
    'formAction' => ($item) ? route('departments.update', ['department' => $item->id]) : route('departments.store'),
])

{{-- Page content --}}
@section('inputFields')

    @include ('partials.forms.edit.name', ['translated_name' => trans('admin/departments/table.name')])

    <!-- Company -->
    @if (\App\Models\Company::canManageUsersCompanies())
        @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
    @endif


    <!-- Manager -->
    @include ('partials.forms.edit.user-select', ['translated_name' => 'HOD', 'fieldname' => 'manager_id'])

    <!-- Location -->
    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

    <div class="form-group {{ $errors->has('building') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="Building">Building<sup style="color:red">*</sup> </label>
                   <div class="col-md-7 col-sm-12 {{  (\App\Helpers\Helper::checkIfRequired($department, 'building')) ? ' required' : '' }}">
      			  {{ Form::select('building', $building , Input::old('building', $item->building), array('class'=>'select2', 'style'=>'min-width:350px')) }}
        		{!! $errors->first('building', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
      </div>
      <div class="form-group {{ $errors->has('floor') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="floor">Floor<sup style="color:red">*</sup> </label>
                  <div class="col-md-7 col-sm-12 {{  (\App\Helpers\Helper::checkIfRequired($department, 'floor')) ? ' required' : '' }}">
      			  {{ Form::select('floor', $floor , Input::old('floor', $item->floor), array('class'=>'select2', 'style'=>'min-width:350px')) }}
        		{!! $errors->first('floor', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    </div>
      <div class="form-group {{ $errors->has('wing') ? 'has-error' : '' }}">
              <label class="col-md-3 control-label" for="wing">Wing<sup style="color:red">*</sup> </label>
	 <div class="col-md-7 col-sm-12 {{  (\App\Helpers\Helper::checkIfRequired($department, 'wing')) ? ' required' : '' }}">
		<select name="wing" class="select2" style="min-width:350px">
    		@foreach($wing as $dpt)
    		@if($dpt == $checkfrwing)
    		<option value="{{$dpt}}" selected>{{$dpt}}</option>
    		@else
    		<option value="{{$dpt}}">{{$dpt}}</option>
    		@endif

		 	@endforeach
	</select>
	</div>
</div>


    <input type="hidden" name="wingvalue" id="wingvalue" value="{{ $checkfrwing }}">

    <div class="form-group {{ $errors->has('room_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="room_name">Room Name<sup style="color:red">*</sup>  </label>
                  <div class="col-md-7  	">
                    <input
                      class="form-control"
                      type="text"
                      name="room_name"
                      id="room_name"
                      value="{{ $checkfrroom }}">

                  </div>
      </div>
      <input type="hidden" name="roomvalue" id="roomvalue" value="{{ $checkfrroom }}">

      <div class="form-group {{ $errors->has('extension_no') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="extension">Extension No </label>
                  <div class="col-md-7  	">
                    <input
                      class="form-control"
                      type="text"
                      name="extension_no"
                      id="extension_no"
                      value="{{ Input::old('extension_no', $item->extension_no) }}">

                  </div>
      </div>


@stop
