<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Item;
use App\Models\Item_Detail;
use App\Models\Order;
use App\Models\Unit;
use App\Models\Order_Misc;
use Collective\Html\FormFacade as Form;
use Datatables;
use DB;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\FBV\Invoice;

class OrdersController extends Controller
{
  public $show_action = true;
  public $view_col = 'job_number';
  public $listing_cols = ['id', 'job_number', 'team_leader', 'area_id', 'date', 'user_id', 'total'];
  public $order_items_cols = ['id', 'activity', 'item', 'amount', 'quantity', 'measurement', 'unit', 'subtotal'];

  public function __construct()
  {
    parent::__construct();
    // Field Access of Listing Columns
    if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
      $this->middleware(function ($request, $next) {
        $this->listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->listing_cols);
        return $next($request);
      });
    } else {
      $this->listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->listing_cols);
    }
  }

  /**
   * Display a listing of the Orders.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $module = Module::get('Orders');
    // return $this->generateInvoice();

    if (Module::hasAccess($module->id)) {
      return View('la.orders.index', [
        'show_actions' => $this->show_action,
        'listing_cols' => $this->listing_cols,
        'module' => $module,
      ]);
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  /**
   * Show the form for creating a new order.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created order in database.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (Module::hasAccess("Orders", "create")) {
      $rules = Module::validateRules("Orders", $request);
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      // Add user id who created the order
      $request->user_id = Auth::id();
      $insert_id = Module::insert("Orders", $request);
      return redirect(config('laraadmin.adminRoute') . "/orders/" . $insert_id . '?additem');
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  /**
   * Store order items in database.
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function addItems(Request $request)
  {
    if (Module::hasAccess("Items", "create")) {
      $orderId = $request->order_id;
      $activityId = $request->activity_id;

      foreach ($request->items as $itemId => $item) {
        $quantity = (int) $item['quantity'];
        $measurement = (int) $item['measurement'];

        // Check quantity and measurement
        if (!$quantity || $quantity <= 0) continue;        
        if (!$measurement || $measurement <= 0) continue;

        $amount = (float) $item['amount'];
        $subtotal = (float) $quantity * $amount;
        
        $itemModel = new Item;
        $itemModel->order_id = $orderId;
        $itemModel->item_detail_id = $itemId;
        $itemModel->activity_id = $activityId;
        $itemModel->measurement = $item['measurement'];
        $itemModel->unit_id = $item['unit'];
        $itemModel->quantity = $quantity;
        $itemModel->amount = $amount;
        $itemModel->subtotal = $subtotal;
        $itemModel->save();
      }

      $order = new Order;
      $order->calcTotalAmount($orderId);
      return redirect(config('laraadmin.adminRoute') . "/orders/" . $orderId);
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  /**
   * Display the specified order.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (Module::hasAccess("Orders", "view")) {
      $order = Order::find($id);
      if (isset($order->id)) {
        $module = Module::get('Orders');
        $otherCharges = Module::get('Order_Miscs');
        $module->row = $order;
        $activities = Activity::lists('name', 'id');
        
        return view('la.orders.show', [
          'module' => $module,
          'other_charges' => $otherCharges,
          'view_col' => $this->view_col,
          'no_header' => true,
          'no_padding' => "no-padding",
          'activities' => $activities,
          'items_cols' => $this->order_items_cols
        ])->with('order', $order);
      } else {
        return view('errors.404', [
          'record_id' => $id,
          'record_name' => ucfirst("order"),
        ]);
      }
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  /**
   * Show the form for editing the specified order.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    if (Module::hasAccess("Orders", "edit")) {
      $order = Order::find($id);
      if (isset($order->id)) {
        $module = Module::get('Orders');

        $module->row = $order;

        return view('la.orders.edit', [
          'module' => $module,
          'view_col' => $this->view_col,
        ])->with('order', $order);
      } else {
        return view('errors.404', [
          'record_id' => $id,
          'record_name' => ucfirst("order"),
        ]);
      }
    } else {
      return redirect(config('laraadmin.adminRoute') . "/orders");
    }
  }

  /**
   * Update the specified order in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if (Module::hasAccess("Orders", "edit")) {
      $rules = Module::validateRules("Orders", $request, true);
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $insert_id = Module::updateRow("Orders", $request, $id);
      return redirect(config('laraadmin.adminRoute') . "/orders/" . $id);
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  /**
   * Remove the specified order from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Module::hasAccess("Orders", "delete")) {
      Order::find($id)->delete();

      // Redirecting to index() method
      return redirect()->route(config('laraadmin.adminRoute') . '.orders.index');
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  public function dtajaxOrderItems($id, Request $request)
  {
    $values = DB::table(Item::getTableName() . ' AS item')
      ->leftJoin(Item_Detail::getTableName() . ' AS item_detail', 'item.item_detail_id', '=', 'item_detail.id')
      ->leftJoin(Activity::getTableName() . ' AS activity', 'item.activity_id', '=', 'activity.id')
      ->leftJoin(Unit::getTableName() . ' AS unit', 'item.unit_id', '=', 'unit.id')
      ->select('item.id', 'activity.name AS activity', 'item_detail.name AS item', 'item.amount', 'item.quantity', 'item.measurement', 'unit.unit', 'item.subtotal')
      ->where('item.order_id', $id)
      ->whereNull('item.deleted_at')
      ->whereNull('item_detail.deleted_at');

    $out = Datatables::of($values)->make();
    $data = $out->getData();

    // Get units
    $units = Unit::all();
    
    for ($i = 0; $i < count($data->data); $i++) {
      $output = '';
      if (Module::hasAccess('Items', 'edit')) {
        // Quantity
        $data->data[$i][4] = '<input type="number" value="' . $data->data[$i][4] . '" class="form-control input-sm inline-edit disabled" min="1" style="width:100%" data-type="quantity" data-id="' . $data->data[$i][0] . '">';

        // Measurement
        $data->data[$i][5] = '<input type="text" value="' . $data->data[$i][5] . '" class="form-control input-sm inline-edit disabled" min="1" style="width:100%" data-type="measurement" data-id="' . $data->data[$i][0] . '">';

        $options = '';
        for ($j = 0; $j < count($units); $j++) {
          if ($data->data[$i][6] == $units[$j]->unit) {
            $options .= '<option selected value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>';
          } else {
            $options .= '<option value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>';
          }          
        }

        // Unit
        $data->data[$i][6] = '<select class="form-control input-sm inline-edit disabled" style="width:100%" data-type="unit" data-id="' . $data->data[$i][0] . '">' . $options . '</select>';
      }

      if (Module::hasAccess("Items", "delete")) {
        $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.items.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
        $output .= ' <button class="btn btn-danger btn-xs item-delete" type="submit"><i class="fa fa-times"></i></button>';
        $output .= Form::close();
      }

      $data->data[$i][] = (string) $output;
    }

    $out->setData($data);
    return $out;
  }

  /**
   * Datatable Ajax fetch
   *
   * @return
   */
  public function dtajax()
  {
    $values = DB::table('orders')
      ->select($this->listing_cols)
      ->whereNull('deleted_at');
    
    // List user created order if not admin, otherwise display all orders
    if (!Auth::user()->isAdministrator()) {
      $values->where('user_id', Auth::user()->id);
    }

    $out = Datatables::of($values)->make();
    $data = $out->getData();

    $fields_popup = ModuleFields::getModuleFields('Orders');

    for ($i = 0; $i < count($data->data); $i++) {
      for ($j = 0; $j < count($this->listing_cols); $j++) {
        $col = $this->listing_cols[$j];
        if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
          $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
        }
        if ($col == $this->view_col) {
          $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/orders/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
        }
      }

      if ($this->show_action) {
        $output = '';
      
        if (Module::hasAccess("Orders", "edit")) {
          $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/orders/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
        }

        if (Module::hasAccess("Orders", "delete")) {
          $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.orders.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
          $output .= ' <button class="btn btn-danger btn-xs btn-delete" type="submit"><i class="fa fa-times"></i></button>';
          $output .= Form::close();
        }
        $data->data[$i][] = (string) $output;
      }
    }
    $out->setData($data);
    return $out;
  }

  /**
   * Datatable Order items
   *
   * @param {id} Activity Id
   */
  public function getItemDetailsByActivityId(Request $request)
  {
    $model = Item_Detail::where('activity_id', $request->id)
      ->where('area_id', $request->areaId)
      ->whereNull('deleted_at')
      ->orderBy('name', 'ASC')
      ->get();
    $units = Unit::pluck('unit', 'id')->toArray();
    $unitOptions = '';
    foreach ($units as $id => $unit) {
      $unitOptions .= '<option value="' . $id . '">' . $unit . '</option>';
    }

    foreach ($model as $row) {
      // Add unit selection
      $row->amount = number_format($row->amount, 2);
      $row->quantity = '<input style="width: 100px" type="number" name="items[' . $row->id . '][quantity]" class="quantity form-control input-sm" data-amount="' . $row->amount . '" data-id="' . $row->id . '" min="1">';
      $row->measurement = '<input style="width: 100px" type="number" name="items[' . $row->id . '][measurement]" class="form-control input-sm" min="1">';
      $row->unit = '<select style="width: 100px" name="items[' . $row->id . '][unit]" class="form-control input-sm">' . $unitOptions . '</select>';
      $row->subtotal = '<span class="subtotalLabel">₱0.00</span><input type="hidden" name="items[' . $row->id . '][amount]" value="' . $row->amount . '">';
    }
    return $model->toJson();
  }

  public function editItems(Request $request)
  {
    $hasModifications = false;
    // Update quantity
    if ($request->get('quantity')) {
      array_map(function($value, $id) use ($request) {
        if (!$value || $value <= 0) return;
        $item = Item::find($id);
        $item->quantity = (int) $value;
        $item->subtotal = $item->amount * $value;
        $item->save();
        $order = new Order;
        $order->calcTotalAmount($request->get('orderId'));        
      }, $request->get('quantity'), array_keys($request->get('quantity')));
      $hasModifications = true;
    }

    // Update measurement
    if ($request->get('measurement')) {
      array_map(function ($value, $id) {
        if (!$value || $value <= 0) return;
        $item = Item::find($id);
        $item->measurement = (int) $value;
        $item->save();        
      }, $request->get('measurement'), array_keys($request->get('measurement')));
      $hasModifications = true;
    }

    // Update unit
    if ($request->get('unit')) {
      array_map(function($value, $id) {
        $item = Item::find($id);
        $item->unit_id = (int) $value;
        $item->save();
      }, $request->get('unit'), array_keys($request->get('unit')));
      $hasModifications = true;
    }

    return response()->json(['has_modifications' => $hasModifications]);
  }

  public function generateInvoice(Request $request)
  {
    if (Module::hasAccess("Orders", "view")) {
      $order = Order::find($request->id);

      if (isset($order->id)) {
        $invoice = Invoice::make()
          ->template('fbv')
          ->number($order->job_number)
          ->accountName($order->user->name)
          ->area($order->area->name)
          ->dateDone($order->date)
          ->timeStart($order->timeStart)
          ->timeEnd($order->timeEnd)
          ->totalInvoice($order->total)
          ->currency('&#8369;');

        $items = Item::leftJoin(Item_Detail::getTableName() . ' as item_detail', 'item_detail_id', '=', 'item_detail.id')
          ->leftJoin(Unit::getTableName() . ' as unit', 'unit_id', '=', 'unit.id')
          ->select('items.id', 'item_detail.name', 'items.measurement', 'items.quantity', 'items.amount', 'unit.unit')
          ->where('order_id', '=', $order->id)
          ->whereNull('items.deleted_at')
          ->whereNull('item_detail.deleted_at')
          ->orderBy('items.id', 'ASC')
          ->get();

        foreach ($items as $index => $item) {
          $invoice->addItem($item->name, $item->amount, $item->quantity, $index+1, $item->measurement, $item->unit);
        }

        $misc = Order_Misc::where('order_id', $request->id)
          ->whereNull('deleted_at')
          ->get();

        foreach($misc as $index => $item) {
          $invoice->addMisc($item->activity, $item->quantity, $item->unit, $item->amount);
        }

        // Generate Invoice
        $invoice->show();
      }
    }
  }
}
