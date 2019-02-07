<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Activity;

class ActivitiesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
  public $listing_cols = ['id', 'name'];
  public $item_listing_cols = ['id', 'name', 'amount', 'area', 'activity_id'];
	
	public function __construct() {
    parent::__construct();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Activities', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Activities', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Activities.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Activities');
		
		if(Module::hasAccess($module->id)) {
			return View('la.activities.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
      return redirect(config('laraadmin.adminRoute')."/");
    }
	}

	/**
	 * Show the form for creating a new activity.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created activity in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Activities", "create")) {
		
			$rules = Module::validateRules("Activities", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Activities", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.activities.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified activity.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Activities", "view")) {
			
			$activity = Activity::find($id);
			if(isset($activity->id)) {
				$module = Module::get('Activities');
				$module->row = $activity;
				
				return view('la.activities.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
          'no_padding' => "no-padding",
          'items_cols' => $this->item_listing_cols
				])->with('activity', $activity);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("activity"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified activity.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Activities", "edit")) {			
			$activity = Activity::find($id);
			if(isset($activity->id)) {	
				$module = Module::get('Activities');
				
				$module->row = $activity;
				
				return view('la.activities.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('activity', $activity);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("activity"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified activity in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (Module::hasAccess("Activities", "edit")) {
			$rules = Module::validateRules("Activities", $request, true);
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			$insert_id = Module::updateRow("Activities", $request, $id);
			return redirect()->route(config('laraadmin.adminRoute') . '.activities.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified activity from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Activities", "delete")) {
			Activity::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.activities.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
    $values = DB::table('activities')
      ->select($this->listing_cols)
      ->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Activities');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/activities/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Activities", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/activities/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Activities", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.activities.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs btn-delete" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
