@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/orders') }}">Order</a> :
@endsection
@section("contentheader_description", $order->$view_col)
@section("section", "Orders")
@section("section_url", url(config('laraadmin.adminRoute') . '/orders'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Orders Edit : ".$order->$view_col)

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

<div class="box">
	<div class="box-header">

	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($order, ['route' => [config('laraadmin.adminRoute') . '.orders.update', $order->id ], 'method'=>'PUT', 'id' => 'order-edit-form']) !!}
					<div class="form-group">
					{!! Form::label('order_type_id', 'Order Type', ['for' => 'order_type_id']) !!}
					{!! Form::select('order_type_id', $orderType, null, ['id' => 'order_type_id', 'class' => 'form-control', 'rel' => 'select2'] ) !!}
					</div>

					@if ($isActivityTypeVista)
					@la_input($module, 'date')
					@la_input($module, 'subdivision')
					@la_input($module, 'block')
					@la_input($module, 'lot')
					@else
					@la_input($module, 'job_number')
					@la_input($module, 'account_name')
					@la_input($module, 'ot_multiplier', null, null, 'form-control select2-hidden-accessible ot-multiplier')
          @la_input($module, 'has_tax', true)
					@la_input($module, 'tax')
					<!-- @la_input($module, 'area_id') -->
					
					@la_input($module, 'time_start')
					@la_input($module, 'time_finished')
					@endif
					
					<br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/orders') . '/' . $order->id }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$('.ot-multiplier').val({!!$order->ot_multiplier!!}).trigger('change');
	$("#order-edit-form").validate({

	});
});
</script>
@endpush
