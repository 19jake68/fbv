@extends('la.layouts.app')
@push('meta_tags')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<style>
  td {
    vertical-align: middle !important;
  }

  .title-item {
    display: inline-block;
  }

  .btn-add-item {
    margin-top: 7px;
  }

  .th-add-item-110 {
    width: 110px;
  }

  .th-add-item-200 {
    width: 200px;
  }

  .profile2 .label2.total {
    font-size: 20px;
  }

  .th-unit {
    width: 30px;
  }

	.dt-body-center {
		text-align: center;
	}

  .dt-bootstrap .col-sm-12 {
    overflow: hidden;
  }

  .item-delete:focus {
    border: 1px solid #48B0F7;
  }

  #orderItems {
    width: 100% !important;
  }

  .inline-edit.disabled {
    pointer-events: none;
    border-color: transparent;
    background: none;
  }
  .inline-edit:not(.disabled) {
    pointer-events: auto;
    border-color: #d2d6de;
    background-color: white;
  }
</style>
@endpush
  
@section('htmlheader_title')
	Order View
@endsection

@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
			  <div class="col-md-3">
					<!-- <img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt=""> -->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">Job #: {{ $order->$view_col }}</h4>
          <ul class="list-unstyled">
            <li>Area: {{ $order->area->name }}</li>
            <li>Team Leader: {{ $order->team_leader }}</li>
            <li>Date: {{ \Carbon\Carbon::parse($order->date)->format('F d, Y') }}</li>
          </ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
      <div class="dats1 mt10">Added by:</div>
			<div class="dats1"><div class="label2">{{ $order->user->name }}</div></div>
      <div class="dats1"><i class="fa fa-envelope-o"></i> {{ $order->user->email }}</div>
		</div>
		<div class="col-md-4">
			
			<!--<div class="teamview">
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user1-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user2-160x160.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user3-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user4-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user8-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
				<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
			</div>
			
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #1</span>
					<small class="pull-right">20%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">20% Complete</span>
					</div>
				</div>
			</div>
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #2</span>
					<small class="pull-right">90%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 90%" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">90% Complete</span>
					</div>
				</div>
			</div>
			<div class="dats1 pb">
				<div class="clearfix">
					<span class="pull-left">Task #3</span>
					<small class="pull-right">60%</small>
				</div>
				<div class="progress progress-xs active">
					<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only">60% Complete</span>
					</div>
				</div>
			</div>-->

      <div class="dats1 mt10">Total:</div>
      <div class="dats1"><div class="label2 success total">&#8369;{{ number_format($order->total, 2) }}</div></div>
		</div>
		<div class="col-md-1 actions">
			@la_access("Orders", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/orders/'.$order->id.'/edit') }}" class="btn btn-xs btn-edit btn-default" title="Edit Order"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Orders", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.orders.destroy', $order->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit" title="Delete Order"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/orders') }}" data-toggle="tooltip" data-placement="right" title="Back to Orders"><i class="fa fa-chevron-left"></i></a></li>
    <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-items" data-target="#tab-items"><i class="fa fa-list-ol"></i> Items</a></li>
		<!-- <li class=""><a role="tab" data-toggle="tab" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
    <li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li> -->
	</ul>

	<div class="tab-content">
    <div role="tabpanel" class="tab-pane active fade in" id="tab-items">
      <div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4 class="title-item">Items</h4>
            <div class="pull-right">
            @la_access("Items", "create")
              <button class="btn btn-success btn-sm btn-add-item" style="margin-top: 7px" data-toggle="modal" data-target="#addItemModal">Add Items</button>
            @endla_access
            @la_access("Items", "edit")
              <button class="btn btn-primary btn-sm btn-edit-item" style="margin-top: 7px" data-toggle="enable">Edit Items</button>
            @endla_access
            </div>
					</div>
					<div class="panel-body box-body">
            {{ Form::open(['action' => 'LA\OrdersController@editItems', 'id' => 'order-edit-items-form', 'method' => 'post']) }}
						<table id="orderItems" class="table table-bordered table-striped table-hover">
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
            {{ Form::hidden('orderId', $order->id) }}
            {{ Form::close() }}
					</div>
				</div>
			</div>
    </div>
		<div role="tabpanel" class="tab-pane fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'job_number')
						@la_display($module, 'team_leader')
						@la_display($module, 'area_id')
						@la_display($module, 'date')
						@la_display($module, 'time_start')
						@la_display($module, 'time_finished')
						@la_display($module, 'user_id')
						@la_display($module, 'total')
					</div>
				</div>
			</div>
		</div>
    
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<ul class="timeline timeline-inverse">
				<!-- timeline time label -->
				<li class="time-label">
					<span class="bg-red">
						10 Feb. 2014
					</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-envelope bg-blue"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

					<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

					<div class="timeline-body">
					Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
					weebly ning heekya handango imeem plugg dopplr jibjab, movity
					jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
					quora plaxo ideeli hulu weebly balihoo...
					</div>
					<div class="timeline-footer">
					<a class="btn btn-primary btn-xs">Read more</a>
					<a class="btn btn-danger btn-xs">Delete</a>
					</div>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-user bg-aqua"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

					<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
					</h3>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-comments bg-yellow"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

					<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

					<div class="timeline-body">
					Take me to your leader!
					Switzerland is small and neutral!
					We are more like Germany, ambitious and misunderstood!
					</div>
					<div class="timeline-footer">
					<a class="btn btn-warning btn-flat btn-xs">View comment</a>
					</div>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline time label -->
				<li class="time-label">
					<span class="bg-green">
						3 Jan. 2014
					</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-camera bg-purple"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

					<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

					<div class="timeline-body">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					</div>
				</div>
				</li>
				<!-- END timeline item -->
				<li>
				<i class="fa fa-clock-o bg-gray"></i>
				</li>
			</ul>
			<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
		</div>
		
	</div>
	</div>
	</div>
</div>

@la_access("Orders", "create")
<div class="modal fade" id="addItemModal" role="dialog" aria-labelledby="addItemsModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="addItemsModal">Add Items</h4>
			</div>
			{!! Form::open(['action' => 'LA\OrdersController@addItems', 'id' => 'order-add-items-form']) !!}
			<div class="modal-body">
				<div class="box-body">
          {{-- @la_form($module) --}}
          <div class="form-group">
            {{ Form::label('activity', 'Activity*:') }}
            {{ Form::select('activity_id', $activities, null, ['id' => 'activityList', 'class' => 'form-control']) }}
            {{ Form::hidden('order_id', $order->id) }}
          </div>
          
          	<table id="itemList" class="table table-bordered table-striped">
              <thead>
                <tr class="success">
                  <th>Name</th>
                  <th class="th-add-item-110">Amount</th>
                  <th class="th-add-item-110">Quantity</th>
                  <th class="th-add-item-110">Measurement</th>
                  <th class="th-add-item-110">Unit</th>
                  <th class="th-add-item-110">Subtotal</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {!! Form::submit( 'Save', ['class'=>'btn btn-success btn-add-items-ajax']) !!}
				{!! Form::submit( 'Save and Close', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access
@endsection

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/sum().js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/currency.js"></script>
<script>

$(document).ready(function() {
  var request = null;
  let searchParams = new URLSearchParams(window.location.search),
    csrfToken = $('meta[name="csrf-token"]').attr('content'),
    selectedActivity = $('#activityList').val(),
    listItems = function() {
      let url = "{{ url(config('laraadmin.adminRoute') . '/order_get_item_details_by_activity/') }}",
        tableBody = $('#itemList tbody');

      $.ajax({
        url: url + '/' + selectedActivity + '/' + {{ $order->area_id }},
        type: 'GET',
        dataType: 'html',
        beforeSend: function() {
          $('#activityList').attr('disabled', true);
          tableBody.html('');
        },
        success: function(response) {
          let array = $.parseJSON(response);
          $.each(array, function(index, itemDetail) {
            tableBody.append($('<tr>')
              .attr('id', 'item' + itemDetail.id)
              .append($('<td>').append(itemDetail.name))
              .append($('<td>').append('&#8369;' + itemDetail.amount).addClass('text-right'))
              .append($('<td>').append(itemDetail.quantity))
              .append($('<td>').append(itemDetail.measurement))
              .append($('<td>').append(itemDetail.unit))
              .append($('<td class="text-right">').append(itemDetail.subtotal))
            );
          });
        },
        complete: function() {
          $('#activityList').removeAttr('disabled');
        }
      });
    },
    orderItems = $('#orderItems').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url(config('laraadmin.adminRoute') . '/order_dt_ajax_items/' . $order->id) }}",
      searching: true,
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search"
      },
      pageLength: 50,
      select: false,
      columnDefs: [
        { targets: 0, searchable: false, visible: false },
        { data: 'name' },
        { data: 'activity' },
        { className: 'text-right', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), searchable: false, targets: 3 },
        { searchable: false, targets: 4 },
        { searchable: false, targets: 5 },
        { searchable: false, targets: 6 },
        { className: 'text-right subtotal', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 7 },
        { className: 'text-center', searchable: false, orderable: false, targets: [-1] }
      ]
    }),
    addItemModal = $('#addItemModal'),
    calcAmount = function() {
      let sum = orderItems.column(7).data().sum();
      $('.total').html('&#8369;' + sum.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    };

  addItemModal.modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

  // Watch for modal toggle
  addItemModal.on('show.bs.modal', e => {
    listItems();
  });

  $("#activityList").change(function() {
    selectedActivity = $(this).val();
    listItems();
  });

  // Inline Edit
  $('body').on('change', 'input.inline-edit', function(e) {
    let id = $(this).data('id'),
      type = $(this).data('type'),
      value = $(this).val(),
      form = $('#order-edit-items-form');

    form.data('changed', true);
    $(this).attr('name', type + '[' + id + ']');
  });

  // Edit Item
  $('body').on('click', 'button.item-edit', function(e) {
    alert('display edit item modal');
  });

  // Delete item
  $('body').on('click', 'button.item-delete', function(e) {
    let result = confirm('Are you sure you want to delete this item?');

    if (result) {
      let form = $(this).parent().get(0),
        url = $(form).attr('action');
      
      $.ajax({
        type: 'POST',
        url: url,
        data: $(form).serialize(),
        success: function(result) {
          orderItems.ajax.reload(function() {
            calcAmount();
          });
        }
      });
    }
    
    e.preventDefault();
  });

  // Change subtotal - Add Item Modal
  $('body').on('change', 'input.quantity', function() {
    let id = $(this).data('id'),
      quantity = $(this).val(),
      amount = $(this).data('amount'),
      subtotal = quantity * amount,
      subtotalString = "₱" + subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");

      // Set values
      $(this).parent().parent().find('.subtotalLabel').html(subtotalString);
      $(this).parent().find('input[type=hidden]').val(subtotal);
  });

  // Add order items without closing the modal
  $('.btn-add-items-ajax').click(function(e) {
    e.preventDefault();

    let form = $('#order-add-items-form'),
      url = form.attr('action');

    $.ajax({
      type: 'POST',
      url: url,
      data: form.serialize(),
      success: function(result) {
        orderItems.ajax.reload(function() {
          calcAmount();
        });
      }
    });
  });

  // Enable/disable edit items
  $('.btn-edit-item').click(function() {
    let toggle = $(this).data('toggle'),
      form = $('#order-edit-items-form');

    // Change button text
    $(this).text(toggle === 'enable' ? 'Save Items' : 'Edit Items');
    
    // Toggle textbox enable/disable
    $.map($('#orderItems').find('.inline-edit'), function(node) {
      toggle === 'enable' 
        ? $(node).removeClass('disabled')
        : $(node).addClass('disabled');
    });

    // set new toggle value
    let newToggle = toggle === 'enable' ? 'disable' : 'enable';

    // Save to database
    if (newToggle === 'enable' && form.data('changed')) {
      let url = form.attr('action');

      $.ajax({
        type: 'POST',
        url: url,
        data: form.serialize(),
        success: function(result) {
          if (result.has_modifications) {
            orderItems.ajax.reload(function () {
              form[0].reset();
              calcAmount();
            });
          }
        }
      });
    }
    
    $(this).data('toggle', newToggle);
  });

  // Open modal after order creation
  if (searchParams.has('additem')) {
    addItemModal.modal('show');
  }
});
</script>
@endpush