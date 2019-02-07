@extends('la.layouts.app')

@section('htmlheader_title')
	Activity View
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $activity->$view_col }}</h4>
				</div>
			</div>
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-4">
		</div>
		<div class="col-md-1 actions">
			@la_access("Activities", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/activities/'.$activity->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Activities", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.activities.destroy', $activity->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/activities') }}" data-toggle="tooltip" data-placement="right" title="Back to Activities"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
    <li class=""><a role="tab" data-toggle="tab" class="" href="#tab-items" data-target="#tab-items"><i class="fa fa-list-ul"></i> Items</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'name')
					</div>
				</div>
			</div>
		</div>

    <div role="tabpanel" class="tab-pane fade in" id="tab-items">
      <div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4 class="title-item">Items</h4>
					</div>
					<div class="panel-body box-body">
            {{ Form::open(['action' => 'LA\OrdersController@editItems', 'id' => 'order-edit-items-form', 'method' => 'post']) }}
						<table id="items" class="table table-bordered table-striped table-hover" style="width:100%">
              <thead>
                <tr class="success">
                  @foreach( $items_cols as $col )
                  <th class="th-{{$col}}">{{ ucfirst($col) }}</th>
                  @endforeach
                  @la_access("Items", "delete")
									<th style="width:60px">&nbsp;</th>
                  @endla_access
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
            {{ Form::hidden('activityId', $activity->id) }}
            {{ Form::close() }}
					</div>
				</div>
			</div>
    </div>

	</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
  $('#items').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url(config('laraadmin.adminRoute') . '/item_details/dt_ajax_relation/activity/' . $activity->id) }}",
    pageLength: 100,
    select: false,
    searching: false,
    language: {
      lengthMenu: "_MENU_",
      search: "_INPUT_",
      searchPlaceholder: "Search"
    },
    columnDefs: [
      { targets: [4,5], searchable: false, visible: false },
      { width: "80px", className: 'text-right subtotal', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 2 },
    ]
  });
});
</script>
@endpush