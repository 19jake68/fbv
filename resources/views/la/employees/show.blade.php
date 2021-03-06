@extends('la.layouts.app')

@section('htmlheader_title')
	Employee View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $employee->$view_col }}</h4>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="dats1"><div class="label2">{{ $user->type }}</div></div>
		</div>
		<div class="col-md-4">
		</div>
		<div class="col-md-1 actions">
			@if($employee->id == Auth::user()->context_id || Auth::user()->isAdministrator())
				<a href="{{ url(config('laraadmin.adminRoute') . '/employees/'.$employee->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endif

			@la_access("Employees", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.employees.destroy', $employee->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}" data-toggle="tooltip" data-placement="right" title="Back to Employees"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
    @if($employee->id == Auth::user()->context_id || Auth::user()->isAdministrator())
			<li class=""><a role="tab" data-toggle="tab" href="#tab-account-settings" data-target="#tab-account-settings"><i class="fa fa-key"></i> Account settings</a></li>
		@endif
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
						@la_display($module, 'designation')
						@la_display($module, 'activity_type')
            @la_display($module, 'areas')
						@la_display($module, 'gender')
						@la_display($module, 'mobile')
						@la_display($module, 'email')
					</div>
				</div>
			</div>
		</div>

    @if($employee->id == Auth::user()->context_id || Auth::user()->isAdministrator())
		<div role="tabpanel" class="tab-pane fade" id="tab-account-settings">
			<div class="tab-content">
				<form action="{{ url(config('laraadmin.adminRoute') . '/change_password/'.$employee->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="panel">
						<div class="panel-default panel-heading">
							<h4>Change Password</h4>
						</div>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if(Session::has('success_message'))
								<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success_message') }}</p>
							@endif
							<div class="form-group">
								<label for="password" class=" col-md-2">Password</label>
								<div class=" col-md-10">
									<input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" autocomplete="off" required="required" data-rule-minlength="6" data-msg-minlength="Please enter at least 6 characters.">
								</div>
							</div>
							<div class="form-group">
								<label for="password_confirmation" class=" col-md-2">Retype password</label>
								<div class=" col-md-10">
									<input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Retype password" autocomplete="off" required="required" data-rule-equalto="#password" data-msg-equalto="Please enter the same value again.">
								</div>
							</div>
						</div>
            <div class="panel-footer text-right">
              <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Change Password</button>
            </div>
					</div>
				</form>

        @if(Auth::user()->isAdministrator())
        {!! Form::model($employee, ['route' => [config('laraadmin.adminRoute') . '.users.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form', 'class' => 'general-form dashed-row white']) !!}
					{{ csrf_field() }}
					<div class="panel" style="border-top: 1px solid #ddd">
						<div class="panel-default panel-heading">
							<h4>Account Settings</h4>
						</div>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if(Session::has('success_message2'))
								<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success_message2') }}</p>
							@endif

              <div class="form-group">
								<label for="status" class=" col-md-2">Status</label>
								<div class=" col-md-10">
									{{ Form::select('is_active', $isActiveVals, $user->is_active, ['class' => 'form-control']) }}
								</div>
							</div>

              <div class="form-group">
								<label for="changepass" class=" col-md-2">Reset Password</label>
								<div class=" col-md-10">
									<input type="checkbox" id="changepass" name="changepass" value="1">
								</div>
							</div>
						</div>
						<div class="panel-footer text-right">
              <input type="hidden" name="_tab" value="tab-account-settings">
							<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Submit</button>
						</div>
					</div>
				{!! Form::close() !!}
        @endif
			</div>
		</div>
		@endif

	</div>
	</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  let changepass = true;
  $('#changepass').attr('checked', changepass == {{ $user->changepass }} ? true : false);
});
</script>
@endpush
