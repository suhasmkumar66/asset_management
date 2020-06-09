@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Assign Ticket
    @parent
@stop


@section('header_right')
    <a href="/tickets/index" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <form class="form-horizontal" method="post" action="{{ route('tickets.assign.post', $ticket->id) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ticket Id: {{ $ticket->id }}</h3>
                    </div>
         <div class="box-body">
         <div>
         	<span style="color:red"><sup>*</sup>Assign to is Required</span>
         </div>
           	@include ('partials.forms.edit.user-select', ['translated_name' => "Assign To", 'fieldname' => 'assigned_to'])
            @include ('partials.forms.edit.user-select', ['translated_name' => "Co-Ordinator", 'fieldname' => 'coordinator'])
            @include ('partials.forms.edit.user-select', ['translated_name' => "Collaborator", 'fieldname' => 'collaborator'])

                        <div class="box-footer">
                            <a class="btn btn-link" href="/tickets/index">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> Assign</button>
                        </div>
           </div> <!-- /.box-->
            </form>
           @if($results != null)
            <table class="table table-striped Suhas-table table-responsive table-no-bordered">
            	<thead>
            	<tr>
            		<th>Sl No</th>
            		<th>Ticket Id</th>
            		<th>Assigned To</th>
            		<th>Co-ordinator</th>
            		<th>collaborator</th>
            		<th>Assigned By</th>
            		<th>Assigned On</th>
            	</tr>
            	<tbody>
            		@foreach($results as $result)
            		<tr>
            			<td>{{$result['slno']}}</td>
            			<td>{{$ticket->id}}</td>
            			<td>{{$result['assigned_to']}}</td>
            			<td>{{$result['coordinator']}}</td>
            			<td>{{$result['collaborator']}}</td>
            			<td>{{$result['assigned_by']}}</td>
            			<td>{{$result['created_at']}}</td>
            		</tr>
            	@endforeach
            	</tbody>
            	</thead>
            </table>
            @endif
            
           
           
        </div> <!-- /.col-md-7-->
    </div>


@stop
