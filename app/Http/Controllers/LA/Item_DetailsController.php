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

use App\Models\Item_Detail;

class Item_DetailsController extends Controller
{
	public $show_action;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'amount', 'area_id', 'activity_id'];
	
	public function __construct() {
    parent::__construct();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Item_Details', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Item_Details', $this->listing_cols);
    }
    
    $this->show_action = Module::hasAccess("Item_Details", "edit") || Module::hasAccess("Item_Details", "delete");

	}
	
	/**
	 * Display a listing of the Item_Details.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Item_Details');
		
		if(Module::hasAccess($module->id)) {
			return View('la.item_details.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new item_detail.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created item_detail in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (Module::hasAccess("Item_Details", "create")) {
			$rules = Module::validateRules("Item_Details", $request);
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
      }
			
      $insert_id = Module::insert("Item_Details", $request);
      
      if ($request->page) {
        return response()->json(['insert_id' => $insert_id, 'page' => $request->page]);
      }

			return response()->json(['insert_id' => $insert_id]);
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified item_detail.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Item_Details", "view")) {
			
			$item_detail = Item_Detail::find($id);
			if(isset($item_detail->id)) {
				$module = Module::get('Item_Details');
				$module->row = $item_detail;
				
				return view('la.item_details.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('item_detail', $item_detail);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("item_detail"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
  }
  
  public function getItemDetail($id)
  {
    if (Module::hasAccess('Item_Details', 'edit')) {
      $item_detail = Item_Detail::select('id', 'name', 'amount', 'area_id', 'activity_id')->find($id);
      if (isset($item_detail->id)) {
        return response()->json($item_detail);
      } else {
        return response()->json(['code' => 404, 'message' => 'Item not found.'], 404);
      }
    } else {
      return response()->json(['code' => 403, 'message' => 'Unauthorized access.'], 403);
    }
  }

	/**
	 * Show the form for editing the specified item_detail.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Item_Details", "edit")) {			
			$item_detail = Item_Detail::find($id);
			if(isset($item_detail->id)) {	
				$module = Module::get('Item_Details');
				
				$module->row = $item_detail;
				
				return view('la.item_details.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('item_detail', $item_detail);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("item_detail"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified item_detail in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (Module::hasAccess("Item_Details", "edit")) {
			$rules = Module::validateRules("Item_Details", $request, true);
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
        if ($request->isAjax) {
          return response()->json($validator);
        }
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
      $insert_id = Module::updateRow("Item_Details", $request, $id);
      
      if ($request->isAjax) {
        return response()->json(['id' => $insert_id]);
      }
			return redirect()->route(config('laraadmin.adminRoute') . '.item_details.index');
		} else {
      if ($request->isAjax) {
        return response()->json(['code' => 403, 'message' => 'Unauthorized access.'], 403);
      }
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified item_detail from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Item_Details", "delete")) {
			Item_Detail::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.item_details.index');
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
		$values = DB::table('item_details')
			->leftJoin('areas', 'areas.id', '=', 'item_details.area_id')
			->leftJoin('activities', 'activities.id', '=', 'item_details.activity_id')
			->select(['item_details.id', 'item_details.name', 'amount', 'areas.name as area', 'activities.name as activity'])
			->whereNull('item_details.deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Item_Details');
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/item_details/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Item_Details", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/item_details/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-edit btn-xs" data-id="' . $data->data[$i][0] . '" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Item_Details", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.item_details.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs btn-delete" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
  }
  
  /**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtAjaxByRelation(Request $request)
	{
    $values = DB::table('item_details')
      ->select($this->listing_cols)
      ->whereNull('deleted_at');

    if (isset($request->key)) {
      $key = $request->key . '_id';
      $values->where($key, $request->id);
    }

		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Item_Details');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/item_details/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Item_Details", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/item_details/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-edit btn-xs" data-id="' . $data->data[$i][0] . '" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Item_Details", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.item_details.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs btn-delete" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

	public function updateAjax(Request $request)
	{
    $request->isAjax = true;
    return $this->update($request, $request->id);
	}
}
