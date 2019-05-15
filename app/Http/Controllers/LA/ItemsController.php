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
use App\Models\Item;
use App\Models\Item_Detail;
use App\Models\Order;
use App\Models\Unit;

class ItemsController extends Controller
{
	public $show_action;
	public $view_col = 'order_id';
	public $listing_cols = ['id', 'amount', 'order_id', 'activity_id', 'item_detail_id', 'quantity', 'measurement', 'unit_id', 'subtotal'];
	
	public function __construct() {
    parent::__construct();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Items', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Items', $this->listing_cols);
    }
    
    $this->show_action = Module::hasAccess("Items", "edit") || Module::hasAccess("Items", "delete");
	}
	
	/**
	 * Display a listing of the Items.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Items');
		
		if(Module::hasAccess($module->id)) {
			return View('la.items.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new item.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created item in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Items", "create")) {
		
			$rules = Module::validateRules("Items", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Items", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.items.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified item.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Items", "view")) {
			
			$item = Item::find($id);
			if(isset($item->id)) {
				$module = Module::get('Items');
				$module->row = $item;
				
				return view('la.items.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('item', $item);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
  }
  
  /**
   * Update Ajax
   */
  public function ajaxedit(Request $request)
  {
    if (Module::hasAccess('Items', 'edit')) {
      $item = Item::find($request->id);
      $item[$request->type] = $request->value;

      if ($request->type === 'quantity') {
        $item->subtotal = $request->value * $item->amount;
      }

      if ($item->save()) {
        $order = new Order;
        $order->calcTotalAmount($item->order_id);
        return response()->json($this->_getItemDetail($item->id));
      }
    }
  }

	/**
	 * Show the form for editing the specified item.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (Module::hasAccess("Items", "edit")) {			
			$item = Item::find($id);
			if(isset($item->id)) {	
				$module = Module::get('Items');
				
				$module->row = $item;
				
				return view('la.items.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('item', $item);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified item in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Items", "edit")) {
			
			$rules = Module::validateRules("Items", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Items", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.items.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified item from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Items", "delete")) {
			$model = Item::find($id);
      $orderId = $model->order_id;
      $model->delete();
			$order = new Order;
			$order->calcTotalAmount($orderId);
			return redirect(config('laraadmin.adminRoute') . "/orders/" . $orderId);
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
		$values = DB::table('items')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Items');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/items/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Items", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/items/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Items", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.items.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
  }
  
  private function _getItemDetail($itemId) {
    $data = DB::table(Item::getTableName() . ' AS item')
      ->leftJoin(Item_Detail::getTableName() . ' AS item_detail', 'item.item_detail_id', '=', 'item_detail.id')
      ->leftJoin(Activity::getTableName() . ' AS activity', 'item.activity_id', '=', 'activity.id')
      ->leftJoin(Unit::getTableName() . ' AS unit', 'item.unit_id', '=', 'unit.id')
      ->select('item.id', 'activity.name AS activity', 'item_detail.name AS item', 'item.amount', 'item.quantity', 'item.measurement', 'unit.unit', 'item.subtotal')
      ->where('item.id', $itemId);
    return $data->first();
  }
}
