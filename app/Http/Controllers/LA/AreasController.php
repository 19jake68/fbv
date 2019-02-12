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

use App\Models\Area;
use App\Models\Item_Detail;

class AreasController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
  public $listing_cols = ['id', 'name'];
  public $item_listing_cols = ['id', 'name', 'amount', 'area_id', 'activity'];
	
	public function __construct() {
    parent::__construct();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Areas', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Areas', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Areas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Areas');
		
		if (Module::hasAccess($module->id)) {
			return View('la.areas.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
      return redirect(config('laraadmin.adminRoute')."/");
    }
	}

	/**
	 * Show the form for creating a new area.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created area in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (Module::hasAccess("Areas", "create")) {
			$rules = Module::validateRules("Areas", $request);
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
      }

      $insert_id = Module::insert("Areas", $request);
      $items = Item_Detail::select('name', 'amount', 'activity_id')
        ->where('area_id', function($query) {
          $query->select('id')
            ->from(Area::getTableName())
            ->orderBy('id')
            ->first();
        })
      ->get();

      $itemsArr = [];
      foreach($items as $item) {
        $item->area_id = $insert_id;
        $item->amount = 0;
        array_push($itemsArr, $item->toArray());
      }

      Item_Detail::insert($itemsArr);
      return redirect(config('laraadmin.adminRoute') . "/areas/" . $insert_id);
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified area.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Areas", "view")) {
			
			$area = Area::find($id);
			if(isset($area->id)) {
				$module = Module::get('Areas');
        $module->row = $area;
        $itemDetailsModule = Module::get('Item_Details');
				
				return view('la.areas.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
          'no_padding' => "no-padding",
          'items_cols' => $this->item_listing_cols,
          'itemDetailsModule' => $itemDetailsModule
				])->with('area', $area);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("area"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified area.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Areas", "edit")) {			
			$area = Area::find($id);
			if(isset($area->id)) {	
				$module = Module::get('Areas');
				
				$module->row = $area;
				
				return view('la.areas.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('area', $area);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("area"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified area in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (Module::hasAccess("Areas", "edit")) {
			$rules = Module::validateRules("Areas", $request, true);
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Areas", $request, $id);
			return redirect(config('laraadmin.adminRoute') . "/areas/" . $insert_id);
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified area from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (Module::hasAccess("Areas", "delete")) {
      Area::find($id)->items()->forceDelete();
      Area::find($id)->forceDelete();
			return redirect()->route(config('laraadmin.adminRoute') . '.areas.index');
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
		$values = DB::table('areas')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Areas');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/areas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Areas", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/areas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Areas", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.areas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
