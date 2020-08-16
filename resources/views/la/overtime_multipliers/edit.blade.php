@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/overtime_multipliers') }}">Overtime Multiplier</a> :
@endsection
@section("contentheader_description", $overtime_multiplier->$view_col)
@section("section", "Overtime Multipliers")
@section("section_url", url(config('laraadmin.adminRoute') . '/overtime_multipliers'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Overtime Multipliers Edit : ".$overtime_multiplier->$view_col)

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
				{!! Form::model($overtime_multiplier, ['route' => [config('laraadmin.adminRoute') . '.overtime_multipliers.update', $overtime_multiplier->id ], 'method'=>'PUT', 'id' => 'overtime_multiplier-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'type')
					@la_input($module, 'value')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/overtime_multipliers') }}">Cancel</a></button>
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
	$("#overtime_multiplier-edit-form").validate({
		
	});
});
</script>
@endpush
