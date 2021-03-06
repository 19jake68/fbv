@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/order_types') }}">Order Type</a> :
@endsection
@section("contentheader_description", $order_type->$view_col)
@section("section", "Order Types")
@section("section_url", url(config('laraadmin.adminRoute') . '/order_types'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Order Types Edit : ".$order_type->$view_col)

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
				{!! Form::model($order_type, ['route' => [config('laraadmin.adminRoute') . '.order_types.update', $order_type->id ], 'method'=>'PUT', 'id' => 'order_type-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/order_types') }}">Cancel</a></button>
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
	$("#order_type-edit-form").validate({
		
	});
});
</script>
@endpush
