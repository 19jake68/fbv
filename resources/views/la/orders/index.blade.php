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
@section("sub_section", "Listing")
@section("htmlheader_title", "Orders Listing")

@section("headerElems")
@la_access("Orders", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Order</button>
@endla_access
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
	<!--<div class="box-header"></div>-->
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
				<h4 class="modal-title" id="myModalLabel">Add Order</h4>
			</div>
			{!! Form::open(['action' => 'LA\OrdersController@store', 'id' => 'order-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
          {{-- @la_form($module) --}}
          <div class="form-group">
          {!! Form::label('order_type_id', 'Order Type', ['for' => 'order_type_id']) !!}
          {!! Form::select('order_type_id', $orderType, null, ['id' => 'order_type_id', 'class' => 'form-control', 'rel' => 'select2', 'required' => true] ) !!}
          </div>
          @la_input($module, 'company')
          @if(!empty($areas))
          <div class="form-group">
          {!! Form::label('area_id', 'Area* :', ['for' => 'area_id']) !!}
          {!! Form::select('area_id', $areas, null, ['id' => 'area_id', 'class' => 'form-control', 'rel' => 'select2', 'required' => true] ) !!}
          </div>
          @else
          @la_input($module, 'area_id')
          @endif
          
					@la_input($module, 'job_number')
					@la_input($module, 'account_name')
          @la_input($module, 'has_tax')
					@la_input($module, 'date')
					@la_input($module, 'time_start')
					@la_input($module, 'time_finished')
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

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/datetime.js') }}"></script>

<script>
$(function () {
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
    columnDefs: [
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.moment( 'MMM D, YYYY' ), targets: 5 },
      { width: "80px", className: 'text-right', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 7 },
      @if($show_actions)
      { visible: false, targets: [8] },
      { className: 'actions text-center', orderable: false, targets: [-1] }
      @endif
    ]
	});

  $('#AddModal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

	$("#order-add-form").validate({});

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