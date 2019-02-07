@extends("la.layouts.app")

@section("contentheader_title", "Item Details")
@section("contentheader_description", "Item Details listing")
@section("section", "Item Details")
@section("sub_section", "Listing")
@section("htmlheader_title", "Item Details Listing")

@section("headerElems")
@la_access("Item_Details", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Item Detail</button>
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
		<table id="itemDetailTable" class="table table-bordered">
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
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("Item_Details", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Item Detail</h4>
			</div>
			{!! Form::open(['action' => 'LA\Item_DetailsController@store', 'id' => 'item_detail-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
          @la_form($module)
					{{--
					@la_input($module, 'name')
					@la_input($module, 'amount')
					@la_input($module, 'area_id')
					@la_input($module, 'activity_id')
					--}}
				</div>
			</div>
			<div class="modal-footer">
        <input type="hidden" name="page">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
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
$(document).ready(function() {
	let table = $("#itemDetailTable").DataTable({
    pageLength: 100,
		processing: true,
    serverSide: true,
    ajax: "{{ url(config('laraadmin.adminRoute') . '/item_detail_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ 
      { className: 'text-center', orderable: false, targets: [-1] }
    ]
		@endif
	});

	$("#item_detail-add-form").validate({});

  $('#item_detail-add-form').submit(function(e) {
    e.preventDefault();
    $('input[name=page]').val(table.page.info().page);

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: function(response) {
        table.ajax.reload(null, false);
        $('#AddModal').modal('toggle');
      }
    });
  });

  $('body').on('click', '.btn-danger', function(e) {
    e.preventDefault();
    let conf = confirm('Are you sure you want to delete this item?');

    if (conf) {
      let form = $(this).closest('form'),
        url = form.attr('action'),
        method = form.attr('method'),
        data = form.serialize();

      $.ajax({
        type: method,
        url: url,
        data: data,
        success: function() {
          table.ajax.reload(null, false);
        }
      });
    }
  });
});
</script>
@endpush
