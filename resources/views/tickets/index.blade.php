@extends('layouts/default')

{{-- Page title --}}
@section('title')
Tickets
@parent
@stop


@section('header_right')
<a href="{{ route('tickets.create') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

        <table
            data-columns="{{ \App\Presenters\TicketPresenter::dataTableLayout() }}"
            data-cookie-id-table="TicketTable"
            data-pagination="true"
            data-id-table="TicketTable"
            data-search="true"
            data-show-footer="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-refresh="true"
            data-sort-order="asc"
            id="TicketTable"
            class="table table-striped Suhas-table"
            data-url="{{ route('api.tickets.index') }}"
            data-export-options='{
              "fileName": "export-tickets-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table',
      ['exportFile' => 'ticket-export',
      'search' => true,
      'columns' => \App\Presenters\TicketPresenter::dataTableLayout()
  ])
@stop

