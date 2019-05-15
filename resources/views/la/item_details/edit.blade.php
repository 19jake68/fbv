@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/item_details') }}">Item Detail</a> :
@endsection
@section("contentheader_description", $item_detail->$view_col)
@section("section", "Item Details")
@section("section_url", url(config('laraadmin.adminRoute') . '/item_details'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Item Details Edit : ".$item_detail->$view_col)

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
				{!! Form::model($item_detail, ['route' => [config('laraadmin.adminRoute') . '.item_details.update', $item_detail->id ], 'method'=>'PUT', 'id' => 'item_detail-edit-form']) !!}
					@la_form($module)
          <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/item_details') }}">Cancel</a></button>
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
	$("#item_detail-edit-form").validate({
		
	});
});
</script>
@endpush
