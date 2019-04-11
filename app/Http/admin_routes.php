<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['prefix' => config('laraadmin.adminRoute')], function () {
    Route::get('/orders/{order}/print', 'Api\PrintReceiptController@index');
});

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	/* ================== Dashboard ================== */	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
  Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Areas ================== */
	Route::resource(config('laraadmin.adminRoute') . '/areas', 'LA\AreasController');
	Route::get(config('laraadmin.adminRoute') . '/area_dt_ajax', 'LA\AreasController@dtajax');

	/* ================== Activities ================== */
	Route::resource(config('laraadmin.adminRoute') . '/activities', 'LA\ActivitiesController');
	Route::get(config('laraadmin.adminRoute') . '/activity_dt_ajax', 'LA\ActivitiesController@dtajax');

	/* ================== Units ================== */
	Route::resource(config('laraadmin.adminRoute') . '/units', 'LA\UnitsController');
	Route::get(config('laraadmin.adminRoute') . '/unit_dt_ajax', 'LA\UnitsController@dtajax');

	/* ================== Orders ================== */
  Route::resource(config('laraadmin.adminRoute') . '/orders', 'LA\OrdersController');
  Route::post(config('laraadmin.adminRoute') . '/orders/add_items', 'LA\OrdersController@addItems');
  Route::post(config('laraadmin.adminRoute') . '/orders/edit_items', 'LA\OrdersController@editItems');

  Route::get(config('laraadmin.adminRoute') . '/order_dt_ajax', 'LA\OrdersController@dtajax');
  Route::get(config('laraadmin.adminRoute') . '/order_get_item_details_by_activity/{id}/{areaId}', 'LA\OrdersController@getItemDetailsByActivityId');
  Route::get(config('laraadmin.adminRoute') . '/order_dt_ajax_items/{id}', 'LA\OrdersController@dtajaxOrderItems');
  Route::get(config('laraadmin.adminroute') . '/order/generate_invoice/{id}', ['as' => config('laraadmin.adminRoute') . '.orders.generateInvoice', 'uses' => 'LA\OrdersController@generateInvoice']);

	/* ================== Item_Details ================== */
	Route::resource(config('laraadmin.adminRoute') . '/item_details', 'LA\Item_DetailsController');
	Route::post(config('laraadmin.adminRoute') . '/item_details/update_ajax', 'LA\Item_DetailsController@updateAjax');
  Route::get(config('laraadmin.adminRoute') . '/item_detail_dt_ajax', 'LA\Item_DetailsController@dtajax');
  Route::get(config('laraadmin.adminRoute') . '/item_details/dt_ajax_relation/{key}/{id}', 'LA\Item_DetailsController@dtAjaxByRelation');
  Route::get(config('laraadmin.adminRoute') . '/item_detail_ajax/{id}', 'LA\Item_DetailsController@getItemDetail');

	/* ================== Items ================== */
  Route::resource(config('laraadmin.adminRoute') . '/items', 'LA\ItemsController');
  Route::post(config('laraadmin.adminRoute') . '/item_ajax_edit', 'LA\ItemsController@ajaxedit');
  Route::get(config('laraadmin.adminRoute') . '/item_dt_ajax', 'LA\ItemsController@dtajax');
  
  /* Password */
  Route::get(config('laraadmin.adminRoute') . '/password/set', 'Auth\PasswordController@setPasswordPage');
  Route::post(config('laraadmin.adminRoute') . '/setpass', 'Auth\PasswordController@setPassword');


	/* ================== Order_Miscs ================== */
	Route::resource(config('laraadmin.adminRoute') . '/order_miscs', 'LA\Order_MiscsController');
	Route::get(config('laraadmin.adminRoute') . '/order_misc_dt_ajax/{id}', 'LA\Order_MiscsController@dtajax');

	/* ================== Order_Types ================== */
	Route::resource(config('laraadmin.adminRoute') . '/order_types', 'LA\Order_TypesController');
	Route::get(config('laraadmin.adminRoute') . '/order_type_dt_ajax', 'LA\Order_TypesController@dtajax');

/* ================== Reports ================== */
	Route::resource(config('laraadmin.adminRoute') . '/reports', 'LA\ReportsController');
	Route::get(config('laraadmin.adminRoute') . '/report_dt_ajax', 'LA\ReportsController@dtajax');
});	