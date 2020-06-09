@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Ticket Logs
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
           @if($results != null)
            <table class="table table-striped Suhas-table table-responsive table-no-bordered">
            	<thead>
            	<tr>
            		<th>Sl No</th>
            		<th>Ticket Id</th>
            		<th>Status</th>
            		<th>Actions</th>
            		<th>Created On</th>
            		
            	</tr>
            	<tbody>
            		@foreach($results as $result)
            		<tr>
            			<td>{{$result['slno']}}</td>
            			<td>{{$ticket->id}}</td>
            			<td>{{$result['status']}}</td>
            			<td>{{$result['comments']}}</td>
            			<td>{{$result['created_at'] }}</td>
            		</tr>
            	@endforeach
            	</tbody>
            	</thead>
            </table>
            @endif
           </div> <!-- /.box-->
            </form>
           
            
           
           
        </div> <!-- /.col-md-7-->
    </div>


@stop
