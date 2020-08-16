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

  .th-add-item-80 {
    width: 80px
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
  .label-regular {
    font-weight: normal;
  }
</style>
@endpush

@section('htmlheader_title')
	Order View
@endsection

@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix" style="padding-bottom:10px">
		<div class="col-md-4">
			<div class="row">
			  <div class="col-md-3 hidden-xs">
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">Job Order: {{ $order->$view_col }}</h4>
          <ul class="list-unstyled">
            <li>Order Type: {{ $order->orderType->name }}</li>
            <li>Company: {{ $order->company }}
            <li>Area: {{ $order->area->name }}</li>
            <li>Account Name: {{ $order->account_name }}</li>
            <li>Date: {{ $order->date }}</li>
            <li>Started: {{ $order->time_start }}</li>
            <li>Ended: {{ $order->time_finished }}</li>
          </ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
      <div class="hidden-xs" style="margin-top:25px">&nbsp;</div>
      <ul class="list-unstyled">
        <li>Billed by: {{ $order->user->name }}</li>
        <li>Remarks: {{ $order->remarks }}</li>
      </ul>
		</div>
		<div class="col-md-4">
      <div class="dats1 mt10"></div>
      <ul class="list-unstyled">
        @if ($order->has_tax)
          @if ($order->otMulti)
            @php
              $otMultiStr = '';
              $otMultiVal = 0;
            @endphp
          @endif
        <li>Subtotal: <span class="subtotal">&#8369;{{ number_format($order->total, 2) }}</span></li>
        <li>Tax ({{ $order->tax }}%): <span class="tax">&#8369;{{ number_format($order->total_tax_amount, 2) }}</span></li>
        @endif
        <li style="font-size: 20px">Total: <span class="total label label-success label-regular">&#8369;{{ number_format($order->total + $order->total_tax_amount, 2) }}</span>
      </ul>
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
    <!-- <li><a role="tab" data-toggle="tab" href="#tab-misc" data-target="#tab-misc"><i class="fa fa-list-ul"></i> Other Charges</a></li> -->
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
          <div class="form-group">
            <input type="text" class="form-control" id="searchbox" placeholder="Type a keyword to search for an item">
          </div>

          <table id="itemList" class="table table-bordered table-striped">
            <thead>
              <tr class="success">
                <th>Name</th>
                <th class="th-add-item-80">Amount</th>
                <th class="th-add-item-80">Quantity</th>
                <th class="th-add-item-80">Unit</th>
                <th class="th-add-item-80">Subtotal</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            @if ($order->has_tax)
            <tfoot>
              <tr>
                <td colspan="6" style="font-size: 85%"><em>** Note: {{ $order->tax }}% Tax is NOT added on the amount.</em></td>
              </tr>
            </tfoot>
            @endif
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

<!-- Print iFrame -->
<iframe
  id="invoice"
  name="invoice"
  src="{{ route(config('laraadmin.adminRoute') . '.orders.generateInvoice', ['id' => $order->id]) }}"
  style="position: absolute; visibility: hidden"
></iframe>
@endsection

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/sum().js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/currency.js"></script>
<script src="{{ asset('vendor/Print.js-1.0.54/print.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
<script>

$(document).ready(function() {
  var request = null;
  let searchParams = new URLSearchParams(window.location.search),
    csrfToken = $('meta[name="csrf-token"]').attr('content'),
    selectedActivity = $('#activityList').val(),
    listItems = function(keyword) {
      let url = "{{ url(config('laraadmin.adminRoute') . '/order_get_item_details_by_activity/') }}",
        tableBody = $('#itemList tbody'),
        fullUrl = url + '/' + selectedActivity + '/' + {{ $order->area_id }} + '/' + {{ $order->id }};

      if (keyword) {
        fullUrl = fullUrl + '?search=' + keyword;
      }

      $.ajax({
        url: fullUrl,
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
              .append($('<td>').append(itemDetail.unit))
              .append($('<td class="text-right">').append(itemDetail.subtotal))
              .append($('<td>').append(itemDetail.remarks))
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
        { width: "80px", className: 'text-right', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), searchable: false, targets: 3 },
        { width: "80px", searchable: false, targets: 4 },
        { width: "80px", searchable: false, targets: 5 },
        // { width: "80px", searchable: false, targets: 6 },
        { width: "80px", className: 'text-right subtotal', searchable: false, render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;' ), targets: 6 },
        { targets: 8, searchable: false, visible: false },
        { targets: 9, searchable: false, visible: false },
        { width: "50px", className: 'text-center', searchable: false, orderable: false, targets: [-1] }
      ]
    }),
    addItemModal = $('#addItemModal'),
    calcAmount = function() {
      let itemSum = orderItems.column(6).data().sum(),
        total = itemSum;

      $('.total').html('&#8369;' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    },
    refreshInvoice = function() {
      document.getElementById('invoice').src += '';
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
    let value = $(this).val(),
      min = $(this).attr('min');
    if (value < min) return;
    $(this).data('val', value);
  });

  // Change subtotal - Add Item Modal
  $('body').on('change', 'input[type=number]', function() {
    let value = $(this).val(),
      min = $(this).attr('min');

    if (value <= min) {
      value = $(this).data('val');
      $(this).val(parseFloat(min) + 1).focus();
      alert('Value should not be equal to or less than ' + min);
    }

    // Compute subtotal for quantity
    if ($.inArray('quantity', $(this)[0].classList) > -1) {
      let id = $(this).data('id'),
        amount = $(this).data('amount'),
        subtotal = value * amount,
        subtotalString = "₱" + (value * amount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");

      // Set values
      $(this).parent().parent().find('.subtotal').html(subtotalString);
      $(this).parent().find('input[type=hidden]').val(subtotal);
    }
  });

  // Add order items without closing the modal
  $('.btn-add-items-ajax').click(function(e) {
    e.preventDefault();

    let form = $(this).parents('form:first')[0],
      url = $(form).attr('action'),
      method = $(form).attr('method');

    $.ajax({
      type: method,
      url: url,
      data: $(form).serialize(),
      success: function(result) {
        orderItems.ajax.reload(function() {
          calcAmount();
          refreshInvoice();
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
              refreshInvoice();
              // @todo: refresh invoice
            }, false);
          }
        }
      });
    }

    $(this).data('toggle', newToggle);
  });

  $('#searchbox').on('keyup', _.debounce(function(e) {
    let keyword = $(this).val();
    listItems(keyword);
  }, 300));

  $('.btn-print').click(function() {
    window.frames['invoice'].print();
  });

  // Open modal after order creation
  if (searchParams.has('additem')) {
    addItemModal.modal('show');
  }
});
</script>
@endpush
