@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/reports') }}">Report</a> :
@endsection
@section("contentheader_description", $report->$view_col)
@section("section", "Reports")
@section("section_url", url(config('laraadmin.adminRoute') . '/reports'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reports Edit : ".$report->$view_col)

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
				{!! Form::model($report, ['route' => [config('laraadmin.adminRoute') . '.reports.update', $report->id ], 'method'=>'PUT', 'id' => 'report-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'type')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/reports') }}">Cancel</a></button>
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
	$("#report-edit-form").validate({
		
	});
});
</script>
@endpush
