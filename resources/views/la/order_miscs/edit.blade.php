@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/order_miscs') }}">Order Misc</a> :
@endsection
@section("contentheader_description", $order_misc->$view_col)
@section("section", "Order Miscs")
@section("section_url", url(config('laraadmin.adminRoute') . '/order_miscs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Order Miscs Edit : ".$order_misc->$view_col)

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
				{!! Form::model($order_misc, ['route' => [config('laraadmin.adminRoute') . '.order_miscs.update', $order_misc->id ], 'method'=>'PUT', 'id' => 'order_misc-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'activity')
					@la_input($module, 'quantity')
					@la_input($module, 'unit')
					@la_input($module, 'amount')
					@la_input($module, 'order_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/order_miscs') }}">Cancel</a></button>
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
	$("#order_misc-edit-form").validate({
		
	});
});
</script>
@endpush
