@extends('layouts/default')

{{-- Page title --}}
@section('title')
Ticket Reports
@parent
@stop




{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        
          <div class="row">
            <div class="col-md-12">
           
              <div class="col-md-2" id="toolbar">
              	<select name="company_id" class="form-control select2" id="company_id">
              	 <option value=""></option>
              	 @foreach($company as $cmp)
                  <option value="{{$cmp->id}}">{{$cmp->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2" id="toolbar">
                <select name="user_id" class="form-control select2" id="user_id">
                  <option value=""></option>
                  @foreach($users as $user)
                  <option value="{{$user->id}}">{{$user->first_name}}</option>
                  @endforeach
                  
                </select>
                </div>
                
                <div class="col-md-2" id="toolbar">
                <select name="type" class="form-control select2" id="type">
                  <option value=""></option>
                  @foreach($category as $cat)
                  <option value="{{$cat}}">{{$cat}}</option>
                  @endforeach
                  
                </select>
                </div>
                
                <div class="form-group date-range" id="toolbar">
              
              <div class="input-daterange input-group col-md-3" id="datepicker">
                <input type="text" class="input-sm form-control" name="from" id="from" placeholder="From Date" value="" />
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="to" id="to" placeholder="To Date" value ="" />
              </div>
            </div>
               
                  <div class="col-md-2" id="toolbar">
                <button class="btn btn-primary" id="bulkEdit" disabled="disabled">Filter</button>
                <button class="btn btn-primary" id="reset">Reset</button>
                </div>
             
 
			
        <table
            data-columns="{{ \App\Presenters\TicketReportPresenter::dataTableLayout() }}"
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
            data-url="{{ route('api.ticketreports.index') }}"
            data-export-options='{
              "fileName": "export-tickets-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
       
      </div><!-- ./box-body -->
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table',
      ['exportFile' => 'ticket-export',
      'search' => true,
      'columns' => \App\Presenters\TicketReportPresenter::dataTableLayout()
  ])
  <script nonce="{{ csrf_token() }}">
  $('.date-range .input-daterange').datepicker({
      clearBtn: true,
      
      endDate: '0d',
      format: 'yyyy-mm-dd'
  });
  $(function() {
	  $('#user_id, #company_id,#type,#from,#to').change(function() {
		    $('#bulkEdit').prop('disabled', !($('#company_id option:selected').val() != '' || $('#user_id option:selected').val() != '' || $('#type option:selected').val() != ''
			    || $('#from').val().length != 0  || $('#to').val().length != 0));
		  });
	});
	  
$(function () {
	var url = window.location.href;
	var company = url.split("?");
	var company_id_val =  company[1].split("=");
	$('#company_id').val(company_id_val[1])
	
	var user_id_val = company[2].split("=");
	$('#user_id').val(user_id_val[1]);

	var type_id_url = company[3].split("=");
	$('#type').val(type_id_url[1]);

	var from_value = company[4].split("=");
	var checkfrom =from_value[1];
	if(checkfrom == '%'){
		$('#from').val("");
	}
	else{
		$('#from').val(checkfrom);
	}

	var to_value = company[5].split("=");
	var checkto = to_value[1];
	if(checkto == '%'){
		$('#to').val("");
	}
	else{
		$('#to').val(checkto);
	}

	
	
	$("#user_id").select2({
	    placeholder: "Select Agents",
	    allowClear: true
	});
	$("#company_id").select2({
	    placeholder: "Select Company",
	    allowClear: true
	});

	$("#type").select2({
	    placeholder: "Select Category",
	    allowClear: true
	});
	
	

	  
	  $(document).on("click", "#bulkEdit", function(e) {
		var company =   $('#company_id').val();
		var user_id = $('#user_id').val();
		var cat_type = $('#type').val();
		var from_date = $('#from').val();
		var to_date = $('#to').val();
		if(company == null || company == ''){
			var companyurl = '%';
		}
		else{
			companyurl = company;
		}
		if(user_id == null || user_id == ''){
			var userurl = '%';
		}
		else{
			userurl = user_id;
		}
		if(cat_type == null || cat_type == ''){
			var typeurl = '%';
		}
		else{
			typeurl = cat_type;
		}

		if(from_date == null || from_date == ''){
			var fromurl = '%';
		}
		else{
			fromurl = from_date;
		}
		if(to_date == null || to_date == ''){
			var tourl = '%';
		}
		else{
			tourl = to_date;
		}
    $.ajax({
      url: '{{ route('api.ticketreports.postFiltering') }}',
      type: 'POST',
      data: {"user_id": company,"id":"suhas"},
      headers: {
        "X-Requested-With": 'XMLHttpRequest',
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
       
      },
      dataType: 'json',

      success: function (data) {
    	  	window.location.href = 'ticketreports?company='+companyurl+'?user='+userurl+'?type='+typeurl+'?from='+fromurl+'?to='+tourl+'';
	
      },

      error: function (data) {
       
      }


    });
  });

	  $(document).on("click", "#reset", function(e) {
		  window.location.href = 'ticketreports?company=%?user=%?type=%?from=%?to=%';
	  });


});
</script>
@stop

