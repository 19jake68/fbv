@extends('la.layouts.app')
@push('meta_tags')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/Print.js-1.0.54/print.min.css') }}">


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
  .width-45 {
    width: 45px;
  }

  .btn.btn-print {
    color: #398439;
  }
  .btn.btn-print:hover {
    background: #398439;
    color: #fff;
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
      <div class="dats1 mt10">Total:</div>
      <div class="dats1"><div class="label2 success total">&#8369;{{ number_format($order->total, 2) }}</div></div>
		</div>
		<div class="col-md-1 actions">
      <button class="btn btn-xs btn-print btn-default" title="Print Job Order"><i class="fa fa-print"></i></button>

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
    <li><a role="tab" data-toggle="tab" href="#tab-misc" data-target="#tab-misc"><i class="fa fa-list-ul"></i> Other Charges</a></li>
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
		<div role="tabpanel" class="tab-pane fade in" id="tab-misc">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4 class="title-item">Other Charges</h4>
            <div class="pull-right">
            @la_access("Orders", "create")
              <button class="btn btn-success btn-sm btn-add-item" style="margin-top: 7px" data-toggle="modal" data-target="#addOtherChargesModal">Add Other Charges</button>
            @endla_access
            </div>
					</div>
					<div class="panel-body box-body">
						<table id="otherCharges" class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="success">
                  <th>Activity</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Amount</th>
                  @la_access("Orders", "delete")
									<th style="width:60px">&nbsp;</th>
                  @endla_access
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
					</div>
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
<script src="{{ asset('vendor/Print.js-1.0.54/print.min.js') }}"></script>
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
        {  width: "80px", className: 'text-right', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), searchable: false, targets: 3 },
        { width: "80px", searchable: false, targets: 4 },
        { width: "80px", searchable: false, targets: 5 },
        { width: "80px", searchable: false, targets: 6 },
        { width: "80px", className: 'text-right subtotal', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 7 },
        { width: "50px", className: 'text-center', searchable: false, orderable: false, targets: [-1] }
      ]
    }),
    otherChargesTable = $('#otherCharges').DataTable({
      processing: true,
      serverSide: true,
      ajax: "",
      searching: false,
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search"
      },
      pageLength: 50,
      select: false,
      columnDefs: []
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
  $('body').on('change', '.inline-edit', function(e) {
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
          }, false);
        }
      });
    }
    
    e.preventDefault();
  });

  // Get previous value
  $('body').on('focusin', 'input[type=number]', function() {
    let value = $(this).val();
    if (value <= 0) return
    $(this).data('val', value);
  });

  // Change subtotal - Add Item Modal
  $('body').on('change', 'input[type=number]', function() {
    let value = $(this).val();

    if (value <= 0) {
      value = $(this).data('val');
      $(this).val(value).focus();
      alert('Value should not be equal to or less than 0.');
    }

    // Compute subtotal for quantity
    if ($.inArray('quantity', $(this)[0].classList) > -1) {
      let id = $(this).data('id'),
        amount = $(this).data('amount'),
        subtotal = value * amount,
        subtotalString = "₱" + subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");

      // Set values
      $(this).parent().parent().find('.subtotalLabel').html(subtotalString);
      $(this).parent().find('input[type=hidden]').val(subtotal);
    }
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
        }, false);
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
            }, false);
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

  $('.btn-print').click(function() {
    let url = "{{ route(config('laraadmin.adminRoute') . '.orders.generateInvoice', ['id' => $order->id]) }}";
    printJS({
      printable: url,
      type: 'pdf',
      showModal: true
    });
  });
});
</script>
@endpush