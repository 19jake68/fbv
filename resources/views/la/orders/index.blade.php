@extends("la.layouts.app")
@push('styles')
<style>
	.dt-body-center {
		text-align: center;
	}

  .dt-bootstrap .col-sm-12 {
    overflow: hidden;
  }

  #example1 {
    width: 100% !important;
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
		<table id="example1" class="table table-bordered">
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
          @la_input($module, 'area_id')
					@la_input($module, 'job_number')
					@la_input($module, 'team_leader')
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
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
    serverSide: true,
    ajax: "{{ url(config('laraadmin.adminRoute') . '/order_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [
      { visible: false, searchable: false, targets: [0] },
      { className: 'dt-body-center', orderable: false, targets: [-1] }
    ]
		@endif
	});

  $('#AddModal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

	$("#order-add-form").validate({});
});
</script>
@endpush