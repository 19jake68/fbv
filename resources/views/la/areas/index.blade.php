@extends("la.layouts.app")

@section("contentheader_title", "Areas")
@section("contentheader_description", "Areas listing")
@section("section", "Areas")
@section("sub_section", "Listing")
@section("htmlheader_title", "Areas Listing")

@section("headerElems")
@la_access("Areas", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Area</button>
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
		<table id="areaTable" class="table table-bordered">
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

@la_access("Areas", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Area</h4>
			</div>
			{!! Form::open(['action' => 'LA\AreasController@store', 'id' => 'area-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
          @la_form($module)
				</div>
			</div>
			<div class="modal-footer">
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
$(function () {
	let datatable = $("#areaTable").DataTable({
    pageLength: 100,
		processing: true,
    serverSide: true,
    ajax: "{{ url(config('laraadmin.adminRoute') . '/area_dt_ajax') }}",
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
	$("#area-add-form").validate({});

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
