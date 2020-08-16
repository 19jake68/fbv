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

use App\Models\Overtime_Multiplier;

class Overtime_MultipliersController extends Controller
{
	public $show_action = true;
	public $view_col = 'type';
	public $listing_cols = ['id', 'type', 'value'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Overtime_Multipliers', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Overtime_Multipliers', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Overtime_Multipliers.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Overtime_Multipliers');
		
		if(Module::hasAccess($module->id)) {
			return View('la.overtime_multipliers.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new overtime_multiplier.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created overtime_multiplier in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Overtime_Multipliers", "create")) {
		
			$rules = Module::validateRules("Overtime_Multipliers", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Overtime_Multipliers", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.overtime_multipliers.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified overtime_multiplier.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Overtime_Multipliers", "view")) {
			
			$overtime_multiplier = Overtime_Multiplier::find($id);
			if(isset($overtime_multiplier->id)) {
				$module = Module::get('Overtime_Multipliers');
				$module->row = $overtime_multiplier;
				
				return view('la.overtime_multipliers.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('overtime_multiplier', $overtime_multiplier);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("overtime_multiplier"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified overtime_multiplier.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Overtime_Multipliers", "edit")) {			
			$overtime_multiplier = Overtime_Multiplier::find($id);
			if(isset($overtime_multiplier->id)) {	
				$module = Module::get('Overtime_Multipliers');
				
				$module->row = $overtime_multiplier;
				
				return view('la.overtime_multipliers.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('overtime_multiplier', $overtime_multiplier);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("overtime_multiplier"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified overtime_multiplier in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Overtime_Multipliers", "edit")) {
			
			$rules = Module::validateRules("Overtime_Multipliers", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Overtime_Multipliers", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.overtime_multipliers.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified overtime_multiplier from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Overtime_Multipliers", "delete")) {
			Overtime_Multiplier::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.overtime_multipliers.index');
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
		$values = DB::table('overtime_multipliers')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Overtime_Multipliers');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/overtime_multipliers/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Overtime_Multipliers", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/overtime_multipliers/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Overtime_Multipliers", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.overtime_multipliers.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
