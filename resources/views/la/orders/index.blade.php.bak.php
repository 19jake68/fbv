@extends("la.layouts.app")
@push('styles')
<style>
  .dt-bootstrap .col-sm-12 {
    overflow: hidden;
  }

  table.dataTable {
    width: 100% !important;
  }

  .actions {
    min-width: 55px;
  }
</style>
@endpush
@section("contentheader_title", "Orders")
@section("contentheader_description", "Orders listing")
@section("section", "Orders")
@section("sub_section", "List ing")
@section("htmlheader_title", "Orders Listing")

@section("headerElems")
<div class="pull-right text-right">
@la_access("Orders", "create")
&nbsp;<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddModal">Add Order</button>
@endla_access
@if(Auth::user()->isAdministrator())
<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ReportModal">Reports</button>
@endif
</div>
@endsection

@section("main-content")

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="box box-success">
	<div class="box-body">
		<table id="orderTable" class="table table-bordered">
      <thead>
      <tr class="success">
        @foreach( $listing_cols as $col )
        <th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
        @endforeach
        @if($show_actions)
        <th>Actions</th>
        @endif
      </tr>
      </thead>
      <tbody></tbody>
		</table>
	</div>
</div>

@la_access("Orders", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Order - {{ $activityTypeLabel }}</h4>
			</div>
			{!! Form::open(['action' => 'LA\OrdersController@store', 'id' => 'order-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
          <div class="form-group">
            {!! Form::label('order_type_id', 'Order Type*', ['for' => 'order_type_id']) !!}
            {!! Form::select('order_type_id', $orderType, null, ['id' => 'order_type_id', 'class' => 'form-control', 'rel' => 'select2', 'required' => true] ) !!}
          </div>
          <div class="form-group">
            {!! Form::label('area_id', 'Area* :', ['for' => 'area_id']) !!}
            {!! Form::select('area_id', $areas, null, ['id' => 'area_id', 'class' => 'form-control', 'rel' => 'select2', 'required' => true] ) !!}
          </div>

          @if ($isActivityTypeVista)
            @la_input($module, 'meter_no')
            @la_input($module, 'date')
            @la_input($module, 'subdivision')
            @la_input($module, 'block')
            @la_input($module, 'lot')

          @else
            @la_input($module, 'job_number')
            @la_input($module, 'account_name')
            @la_input($module, 'ot_multiplier')
            @la_input($module, 'has_tax', true)
            @la_input($module, 'tax')
            @la_input($module, 'time_start')
            @la_input($module, 'time_finished')
            @la_input($module, 'remarks')
          @endif
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Add Items', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@if(Auth::user()->isAdministrator())
<div class="modal fade" id="ReportModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
  {!! Form::open(['action' => 'LA\OrdersController@generateReport', 'id' => 'order-generate-report-form', 'novalidate' => 'novalidate']) !!}
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Generate Reports</h4>
			</div>
			<div class="modal-body">
				<div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                {{ Form::label('start_date', 'Start Date *:') }}
                {{ Form::text('startDate', null, ['id' => 'start_date2', 'class' => 'datepicker form-control', 'required' => 1]) }}
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                {{ Form::label('end_date', 'End Date *:') }}
                {{ Form::text('endDate', null, ['id' => 'end_date2', 'class' => 'datepicker form-control', 'required' => 1]) }}
              </div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('activity_type2', 'Activity Type:') }}
            {{ Form::select('activityTypeId', $reports->activity_type, null, ['id' => 'activity_type2', 'class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('order_type2', 'Order Type:') }}
            {{ Form::select('orderTypeId', $reports->order_type, null, ['id' => 'order_type2', 'class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('activity2', 'Activity:') }}
            {{ Form::select('activityId', $reports->activities, null, ['id' => 'activity2', 'class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('area2', 'Area:') }}
            {{ Form::select('areaId', $reports->areas, null, ['id' => 'area2', 'class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('employee2', 'Billed By:') }}
            {{ Form::select('userId', $reports->employees, null, ['id' => 'employee2', 'class' => 'form-control']) }}
          </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {!! Form::submit( 'Generate Report', ['class'=>'btn btn-success']) !!}
			</div>
		</div>
  {!! Form::close() !!}
  </div>
</div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/datetime.js') }}"></script>

<script>
$(function () {
  let columnDefsVista = [
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.moment( 'MMM D, YYYY' ), targets: 5 },
      { visible: {{ $showUserColumn ? 'true' : 'false' }}, targets: [6] },
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 7 },
      @if($show_actions)
      { className: 'actions text-center', orderable: false, targets: [-1] }
      @endif
    ];
  let columnDefsJV = [
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.moment( 'MMM D, YYYY' ), targets: 6 },
      { visible: {{ $showUserColumn ? 'true' : 'false' }}, targets: [7] },
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 8 },
      { visible: false, targets: [9] },
      @if($show_actions)
      { className: 'actions text-center', orderable: false, targets: [-1] }
      @endif
    ];

	let datatable = $("#orderTable").DataTable({
    pageLength: 100,
		processing: true,
    serverSide: true,
    ajax: "{{ url(config('laraadmin.adminRoute') . '/order_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
    },
    order: [
      [ 0, 'desc' ]
    ],
    columnDefs: {{ $isActivityTypeVista ? 'columnDefsVista' : 'columnDefsJV' }}
	});

  $('#AddModal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

  $( ".datepicker" ).datetimepicker({
    format: 'YYYY-MM-DD'
  });

	$("#order-add-form").validate({});
  $("#order-generate-report-form").validate({});

  @if($show_actions)
  // Delete item
  $('body').on('click', 'button.btn-delete', function(e) {
    let result = confirm('Are you sure you want to delete this item?');

    if (result) {
      let form = $(this).parent().get(0),
        url = $(form).attr('action');

      $.ajax({
        type: 'POST',
        url: url,
        data: $(form).serialize(),
        success: function(result) {
          datatable.ajax.reload(function() {
            // callback
          }, false);
        }
      });
    }

    e.preventDefault();
  });
  @endif
});
</script>
@endpush
