@extends('layouts/edit-form', [
    'createText' => "Create Ticket",
    'updateText' => "Update Ticket",
    'formAction' => ($item) ? route('tickets.update', ['ticket' => $item->id]) : route('tickets.store'),
])

@section('inputFields')

 <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="first_name">Name<sup style="color:red">*</sup> </label>
                  <div class="col-md-7  {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'first_name')) ? ' required' : '' }}">
                    <input
                      class="form-control"
                      type="text"
                      name="first_name"
                      id="first_name"
                      value="{{ Input::old('first_name', $item->first_name) }}">
                      {!! $errors->first('first_name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                  
      </div>
      
       <div class="form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="extension">Employee Id<sup style="color:red">*</sup> </label>
                  <div class="col-md-7  {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'employee_id')) ? ' required' : '' }}">
                    <input
                      class="form-control"
                      type="text"
                      name="employee_id"
                      id="employee_id"
                      value="{{ Input::old('employee_id', $item->employee_id) }}">
                       {!! $errors->first('employee_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                  
      </div>

@include ('partials.forms.edit.name', ['translated_name' => "Issue"])

<!-- Type -->
<div class="form-group {{ $errors->has('category_type') ? ' has-error' : '' }}">
    <label for="category_type" class="col-md-3 control-label">Issue Type<sup style="color:red">*</sup></label>
    <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'category_type')) ? ' required' : '' }}">
        {{ Form::select('category_type', $category_type , Input::old('category_type', $item->category_type), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('category_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])
               

<div class="form-group {{ $errors->has('department') ? ' has-error' : '' }}">
    <label for="department" class="col-md-3 control-label">Department<sup style="color:red">*</sup></label>
    <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'department')) ? ' required' : '' }}">
        <select name="department" class="select2" style="width:100%">
        	<option></option>
        	@foreach($department as $dpt)
        	@if($dpt->id  == $item->department && $dpt->wing_id == $item->wing_id && $dpt->room_id == $item->room_id)
        	 <option value="{{ $dpt->id }}::{{ $dpt->wing_id }}::{{ $dpt->room_id }}" selected> {{ $dpt->name }} - {{ $dpt->building }} - {{ $dpt->floor }} - {{ $dpt->wing }} - {{ $dpt->room_name}}</option>
        	 @else
   			 <option value="{{ $dpt->id }}::{{ $dpt->wing_id }}::{{ $dpt->room_id }}"> {{ $dpt->name }} - {{ $dpt->building }} - {{ $dpt->floor }} - {{ $dpt->wing }} - {{ $dpt->room_name}}</option>
   			 @endif
 			 @endforeach   
   			         
</select>
        {!! $errors->first('department', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

      <div class="form-group {{ $errors->has('extension') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="extension">Extension<sup style="color:red">*</sup> </label>
                  <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'extension')) ? ' required' : '' }} 	">
                    <input
                      class="form-control"
                      type="text"
                      name="extension"
                      id="extension"
                      value="{{ Input::old('extension', $item->extension) }}">
                      {!! $errors->first('extension', '<span class="alert-msg"><i class="fa fa-times"></i>:message</span>') !!}
                  </div>
      </div>

<div class="form-group {{ $errors->has('priority_type') ? ' has-error' : '' }}">
    <label for="category_type" class="col-md-3 control-label">Priority<sup style="color:red">*</sup></label>
    <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'priority_type')) ? ' required' : '' }}">
        {{ Form::select('priority_type', $priority_type , Input::old('priority_type', $item->priority_type), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('priority_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@if(Auth::user()->isSelfAssigned($item->id) == true)
	<div class="form-group {{ $errors->has('ststus') ? ' has-error' : '' }}">
    <label for="status" class="col-md-3 control-label">Status<sup style="color:red">*</sup></label>
    <div class="col-md-7">
        {{ Form::select('status', $status , Input::old('status', $item->status), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('status', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('comment') ? 'error' : '' }}">
    <label for="comment" class="col-md-3 control-label">Comment</label>
    <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($ticket, 'priority_type')) ? ' required' : '' }}">
        {{ Form::textarea('comment', Input::old('comment', $item->comment), array('class' => 'form-control')) }}
        {!! $errors->first('comment', '<span class="alert-msg"><i class="fa fa-times"></i>:message</span>') !!}
    </div>
</div>

@stop

@section('content')
@parent






@stop

