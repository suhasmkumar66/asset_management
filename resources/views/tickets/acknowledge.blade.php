@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Acknowledge Ticket
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
            <form class="form-horizontal" method="post" action="{{ route('tickets.ack.post', $ticket->id) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ticket Id: {{ $ticket->ticket_id }}</h3>
                    </div>
         <div class="box-body">
           	<div class="form-group {{ $errors->has('comment') ? 'error' : '' }}">
   				 <label for="comment" class="col-md-3 control-label">Feedback<sup style="color:red">*</sup></label>
    					<div class="col-md-7">
       					 {{ Form::textarea('comment', Input::old('comment', ''), array('class' => 'form-control')) }}
      						 
    				</div>
				</div>

                        <div class="box-footer">
                            <a class="btn btn-link" href="/tickets/index">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i>Acknowledge</button>
                        </div>
           </div> <!-- /.box-->
            </form>
           
            
           
           
        </div> <!-- /.col-md-7-->
    </div>


@stop
