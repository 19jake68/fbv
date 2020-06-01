<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Item_Detail;
use App\Models\Order;
use App\Models\Unit;
use App\Models\Order_Type;
use Carbon\Carbon;
use Collective\Html\FormFacade as Form;
use Datatables;
use DB;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\FBV\Invoice;
use PdfReport;

class OrdersController extends Controller
{
  public $show_action;
  public $view_col = 'job_number';
  public $listing_cols = ['id', 'job_number', 'company', 'account_name', 'area_id', 'date', 'user_id', 'total', 'has_tax'];
  public $order_items_cols = ['id', 'activity', 'item', 'amount', 'quantity', 'unit', 'subtotal', 'remarks', 'has_tax', 'tax'];

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

    $this->show_action = Module::hasAccess("Orders", "edit") || Module::hasAccess("Orders", "delete");

  }

  /**
   * Display a listing of the Orders.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $module = Module::get('Orders');

    if (Module::hasAccess($module->id)) {
      $orderType = Order_Type::whereNull('deleted_at')->lists('name', 'id');
      $params = [
        'show_actions' => $this->show_action,
        'listing_cols' => $this->listing_cols,
        'module' => $module,
        'orderType' => $orderType
      ];

      if (!Auth::user()->isAdministrator()) {
        $areas = Auth::user()->employee()->first()->areas;
        $areas = json_decode($areas);
        $areas = Area::whereIn('id', $areas)->lists('name', 'id');
        $params['areas'] = $areas;
      }

      // Display report generator on admin
      if (Auth::user()->isAdministrator()) {
        $params['reports'] = $this->_setReportsCriteria();
      }

      return View('la.orders.index', $params);
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
      
      // add custom rule
      $rules['job_number'] = 'unique:orders|required|max:255';

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      // Set today's date
      $request->merge([
        'date' => Carbon::today()->format('d/m/Y')
      ]);

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
      $itemModule = Module::get('Items');

      $order = Order::find($orderId);

      foreach ($request->items as $itemId => $item) {
        if ($item['quantity'] === '' || $item['quantity'] <= 0) continue;
        $quantity = $item['quantity'];
        $amount = (float) $item['amount'];
        $subtotal = (float) $quantity * $amount;

        // Save item
        $itemModel = new Item;
        $itemModel->order_id = $orderId;
        $itemModel->item_detail_id = $itemId;
        $itemModel->activity_id = $activityId;
        $itemModel->unit_id = $item['unit'];
        $itemModel->quantity = $quantity;
        $itemModel->amount = $amount;
        $itemModel->subtotal = $subtotal;
        $itemModel->remarks = $item['remarks'];
        $itemModel->has_tax = $order->has_tax;
        $itemModel->tax = $order->tax;
        $itemModel->save();
      }

      // Update order total amount
      $order->calcTotalAmount($orderId);
      $order->setTaxDetails($orderId);
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
        $module->row = $order;
        $activities = Activity::lists('name', 'id');

        if ($order->has_tax) {
          // $itemModel = new Item();
          // dd($itemModel->getTaxDetails($id));
          // dd(Module::get('Item')->getTaxDetails($id));
          // $order->subtotal = ;
          // $order->taxAmount = '';
          // $order->tax = $order->total * (env('TAX') / 100);
          // $order->totalAmount = $order->total + $order->tax;
        }

        // Format dates
        $order->date = Carbon::parse($order->date)->format('M d, Y g:i a');
        $order->time_start = !empty($order->time_start)
         ? Carbon::parse($order->time_start)->format('M d, Y g:i a')
         : '--';
        $order->time_finished = !empty($order->time_finished)
         ? Carbon::parse($order->time_finished)->format('M d, Y g:i a')
         : '--';

        return view('la.orders.show', [
          'module' => $module,
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
        $orderType = Order_Type::whereNull('deleted_at')->lists('name', 'id');
        $module->row = $order;

        return view('la.orders.edit', [
          'module' => $module,
          'view_col' => $this->view_col,
          'orderType' => $orderType
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
      $validator->after(function($validator) use ($request, $id) {
        if (!Order::checkUniqueJobNumberOnUpdate($request->job_number, $id)) {
          $validator->errors()->add('job_number', 'The job number has already been taken.');
        }
      });

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      // @ToDo: Update tax per item once order tax data is modified

      $insert_id = Module::updateRow("Orders", $request, $id);

      // Set tax to all items
      $modelItem = new Item;
      $modelItem->setTaxDetails($insert_id, (bool) $request->has_tax, $request->tax);


      $model = new Order;
      $model->setTaxDetails($id);
      
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
      Item::where('order_id', $id)->delete();
      Order::find($id)->delete();

      // Redirecting to index() method
      return redirect()->route(config('laraadmin.adminRoute') . '.orders.index');
    } else {
      return redirect(config('laraadmin.adminRoute') . "/");
    }
  }

  public function dtajaxOrderItems($id, Request $request)
  {
    // Order
    $orderModel = Order::find($id);

    $values = DB::table(Item::getTableName() . ' AS item')
      ->leftJoin(Item_Detail::getTableName() . ' AS item_detail', 'item.item_detail_id', '=', 'item_detail.id')
      ->leftJoin(Activity::getTableName() . ' AS activity', 'item.activity_id', '=', 'activity.id')
      ->leftJoin(Unit::getTableName() . ' AS unit', 'item.unit_id', '=', 'unit.id')
      ->select('item.id', 'activity.name AS activity', 'item_detail.name AS item', 'item.amount', 'item.quantity', 'unit.unit', 'item.subtotal', 'item.remarks', 'item.has_tax', 'item.tax')
      ->where('item.order_id', $orderModel->id)
      ->whereNull('item.deleted_at')
      ->whereNull('item_detail.deleted_at');

    $out = Datatables::of($values)->make();
    $data = $out->getData();

    // Get units
    $units = Unit::all();

    $itemFields = Module::get('Items')->fields;
    $quantityMinLength = $itemFields['quantity']['minlength'];
    
    for ($i = 0; $i < count($data->data); $i++) {
      $output = '';
      if (Module::hasAccess('Items', 'edit')) {
        // Amount
        if ($orderModel->has_tax && $data->data[$i][8]) {
          $data->data[$i][3] = $this->_calcTax($data->data[$i][3], $data->data[$i][9]);
        }

        $quantity = $data->data[$i][4];
        
        // Quantity
        $data->data[$i][4] = '<input type="number" value="' . $data->data[$i][4] . '" class="quantity form-control input-sm inline-edit disabled" min="' . $quantityMinLength . '" style="width:100%" data-tax="' . $data->data[$i][9] . '" data-has-tax="' . $data->data[$i][8] . '" data-amount="' . $data->data[$i][3] . '" data-type="quantity" data-id="' . $data->data[$i][0] . '">';

        $options = '';
        for ($j = 0; $j < count($units); $j++) {
          if ($data->data[$i][5] == $units[$j]->unit) {
            $options .= '<option selected value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>';
          } else {
            $options .= '<option value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>';
          }          
        }

        // Unit
        $data->data[$i][5] = '<select class="form-control input-sm inline-edit disabled" style="width:100%" data-type="unit" data-id="' . $data->data[$i][0] . '">' . $options . '</select>';
        // Subtotal
        $data->data[$i][6] = ($orderModel->has_tax && $data->data[$i][8]) ? $data->data[$i][3] * $quantity : $data->data[$i][6];
        // Remarks
        $data->data[$i][7] = '<textarea class="form-control input-sm inline-edit disabled" data-type="remarks" data-id="' . $data->data[$i][0] . '" style="resize:vertical;min-height:27px;width:100%">' . $data->data[$i][7] . '</textarea>';
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
      ->leftJoin('employees', 'employees.id', '=', 'orders.user_id')
      ->select(['orders.id', 'job_number', 'company', 'account_name', 'area_id', 'date', 'employees.name', 'total', 'has_tax'])
      ->whereNull('orders.deleted_at');
    
    // List user created order if not admin, otherwise display all orders
    if (!Auth::user()->isAdministrator()) {
      $values->where('user_id', Auth::user()->id);
    }

    $out = Datatables::of($values)->make();
    $data = $out->getData();
    $fields_popup = ModuleFields::getModuleFields('Orders');

    for ($i = 0; $i < count($data->data); $i++) {
      // Calculate Tax
      if ($data->data[$i][8]) { // has tax
        $data->data[$i][7] += round($data->data[$i][7] * (env('TAX') / 100), 2);
      }

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
      ->orderBy('name', 'ASC');

    if ($request->search) {
      $model->where('name', 'like', '%'.$request->search.'%');
    }

    $order = Order::find($request->orderId);
    $model = $model->get();
    $units = Unit::pluck('unit', 'id')->toArray();
    $unitOptions = '';
    foreach ($units as $id => $unit) {
      $unitOptions .= '<option value="' . $id . '">' . $unit . '</option>';
    }

    $itemFields = Module::get('Items')->fields;
    $quantityMinLength = $itemFields['quantity']['minlength'];
    $quantityDefaultValue = $itemFields['quantity']['defaultvalue'];

    foreach ($model as $row) {
      // Add unit selection
      $amount = number_format($row->amount, 2, '.', '');
      $row->amount = $order->has_tax ? $this->_calcTax($row->amount, $order->tax) : $row->amount;
      $row->quantity = '<input style="width: 100px" type="number" step=".01" value="0" name="items[' . $row->id . '][quantity]" class="quantity form-control input-sm" data-taxed-amount="' . $row->amount . '" data-amount="' . $amount . '" data-id="' . $row->id . '" min="' . $quantityMinLength . '">';
      $row->unit = '<select style="width: 100px" name="items[' . $row->id . '][unit]" class="form-control input-sm">' . $unitOptions . '</select>';
      $row->subtotal = '<span class="subtotal">₱0.00</span><input type="hidden" name="items[' . $row->id . '][amount]" value="' . $amount . '">';
      $row->remarks = '<textarea style="resize: vertical;min-height:27px"name="items[' . $row->id . '][remarks]" class="form-control input-sm"></textarea>';
    }
    return $model->toJson();
  }

  public function editItems(Request $request)
  {
    $hasModifications = false;
    // Update quantity
    if ($request->get('quantity')) {
      $minlength = (int) Module::get('Items')->fields['quantity']['minlength'];
      array_map(function($value, $id) use ($request, $minlength) {
        if ($value < $minlength) return;
        $item = Item::find($id);
        $item->quantity = (int) $value;
        $item->subtotal = $item->amount * $value;
        $item->save();
        $order = new Order;
        $order->calcTotalAmount($request->get('orderId'));
        $order->setTaxDetails($request->get('orderId'));
      }, $request->get('quantity'), array_keys($request->get('quantity')));
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

    // Remarks
    if ($request->get('remarks')) {
      array_map(function($value, $id) {
        $item = Item::find($id);
        $item->remarks = $value;
        $item->save();
      }, $request->get('remarks'), array_keys($request->get('remarks')));
      $hasModifications = true;
    }

    return response()->json(['has_modifications' => $hasModifications]);
  }

  public function generateInvoice(Request $request)
  {
    if (Module::hasAccess("Orders", "view")) {
      $order = Order::find($request->id);

      if (isset($order->id)) {
        $timeStart = !empty($order->time_start)
          ? date("M j, Y g:i a", strtotime($order->time_start))
          : '--';
        $timeEnd = !empty($order->time_finished)
          ? date("M j, Y g:i a", strtotime($order->time_finished))
          : '--';
        $invoice = Invoice::make()
          ->template('fbv')
          ->id($order->id)
          ->orderType($order->orderType->name)
          ->business(['name' => $order->company])
          ->biller(['name' => $order->user->name, 'email' => $order->user->email])
          ->customer(['name' => $order->account_name])
          ->number($order->job_number)
          ->area($order->area->name)
          ->dateDone(date("M j, Y"))
          ->timeStart($timeStart)
          ->timeEnd($timeEnd)
          ->totalInvoice($order->total)
          ->hasTax($order->has_tax)
          ->displayTax(false)
          ->subtotal($order->total)
          ->taxAmount($order->total_tax_amount)
          ->notes($order->remarks)
          ->currency('&#8369;');

        // Items
        $items = Item::leftJoin(Item_Detail::getTableName() . ' as item_detail', 'item_detail_id', '=', 'item_detail.id')
          ->leftJoin(Unit::getTableName() . ' as unit', 'unit_id', '=', 'unit.id')
          ->leftJoin(Activity::getTableName() . ' as activity', 'items.activity_id', '=', 'activity.id')
          ->select('activity.name as activity_name', 'items.id', 'item_detail.name', 'items.quantity', 'items.amount', 'unit.unit',  'items.remarks', 'items.activity_id', 'items.has_tax', 'items.tax')
          ->where('order_id', '=', $order->id)
          ->where('items.activity_id', '<>', 11)
          ->whereNull('items.deleted_at')
          ->whereNull('item_detail.deleted_at')
          ->orderBy('activity.name', 'ASC')
          ->orderBy('items.id', 'ASC')
          ->get();

        $groupedItems = [];
        foreach ($items as $index => $item) {
          if ($order->has_tax && $item->has_tax) {
            $item->amount = $this->_calcTax($item->amount, $item->tax);
          }

          $item->totalPrice = $invoice->currency . number_format(bcmul($item->amount, $item->quantity, $invoice->decimals), $invoice->decimals);
          $groupedItems[$item->activity_name][] = $item;
        }
        
        $invoice->addGroupedItems($groupedItems);

        foreach ($items as $index => $item) {
          $invoice->addItem($item->name, $item->amount, $item->quantity, $index+1, $item->unit);
        }

        $others = Item::leftJoin(Item_Detail::getTableName() . ' as item_detail', 'item_detail_id', '=', 'item_detail.id')
          ->leftJoin(Unit::getTableName() . ' as unit', 'unit_id', '=', 'unit.id')
          ->select('items.id', 'item_detail.name', 'items.quantity', 'items.subtotal', 'unit.unit', 'items.remarks', 'items.has_tax', 'items.tax')
          ->where('order_id', '=', $order->id)
          ->where('items.activity_id', '=', 11)
          ->whereNull('items.deleted_at')
          ->whereNull('item_detail.deleted_at')
          ->orderBy('items.id', 'ASC')
          ->get();

        foreach($others as $index => $item) {
          $invoice->addMisc($item->name, $item->quantity, $item->unit, $item->subtotal, $item->remarks, $order->has_tax && $item->has_tax, $item->tax);
        }

        // Generate Invoice
        $invoice->show();
      }
    }
  }

  public function generateReport(Request $request)
  {
    foreach ($request->all() as $key => $value) {
      $$key = $value;
    }

    $adminModel = Employee::where('email', 'fbv.gibe@gmail.com')->first();
    $loggedInPersonnel = Auth::user()->name;
    $dateTimeGenerated = Carbon::now()->timezone('Asia/Manila')->format('M d, Y h:i A');
    $limit = 500;
    $title = 'FBV Order Report';
    $filename = str_replace(' ', '_', $title);
    $meta = [
      'Covered Date' => date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)),
      'Order Type' => 'All',
      'Activity' => 'All',
      'Area' => 'All'
    ];
    $footer = [
      'Prepared by' => $loggedInPersonnel . ' (' . $dateTimeGenerated . ')',
      'Approved by' => $adminModel ? $adminModel->name : 'N/A'
    ];
    $columns = [
      'Job #' => 'job_number',
      'Order Type' => 'order_type',
      // 'Company' => 'company',
      'Account Name' => 'account_name',
      // 'Area' => 'area',
      'Noted By' => 'employee',
      'Date' => 'date',
      'Total' => 'total'
    ];

    if ($activityId) {
      $query = Order::select('company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'), 'activity.name');
    } else {
      $query = Order::select('company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'));
    }

    $query->leftJoin(Area::getTableName() . ' as area', 'area.id', '=', 'area_id')
      ->leftJoin(Employee::getTableName() . ' as user', 'user.id', '=', 'user_id')
      ->leftJoin(Item::getTableName() . ' as item', 'item.order_id', '=', 'orders.id')
      ->leftJoin(Order_Type::getTableName() . ' as order_type', 'order_type.id', '=', 'orders.order_type_id')
      ->whereBetween('date', [$startDate, $endDate])
      ->groupBy('item.order_id')
      ->orderBy('date', 'desc');

    // Add limit for generic reports
    // if (!$areaId && !$userId && !$activityId) {
    //   $query->limit($limit);
    //   $meta['Records Displayed'] = 'First ' . $limit . ' data only';
    // }

    // Order Type condition
    if ($orderTypeId) {
      $query->where('order_type_id', $orderTypeId);
      $orderType = Order_Type::find($orderTypeId);
      $meta['Order Type'] = $orderType->name;
      unset($columns['Order Type']);
    }

    // Area condition
    if ($areaId) {
      $query->where('area_id', $areaId);
      $area = Area::find($areaId);
      $meta['Area'] = $area->name;
      unset($columns['Area']);
    }

    // User details
    if ($userId) {
      $query->where('user_id', $userId);
      $user = Employee::find($userId);
      $footer['Noted By'] = $user->name;
      unset($columns['Noted By']);
    }

    // Activity
    if ($activityId) {
      $query->leftJoin(Activity::getTableName() . ' as activity', 'activity.id', '=', 'item.activity_id')
        ->where('activity_id', $activityId);
      $activity = Activity::find($activityId);
      $meta['Activity'] = $activity->name;
    }

    // Append report date generation
    $filename .= '_' . date('mdY');

    // Generate
    return PdfReport::of($title, $meta, $query, $columns, $footer)
      ->editColumn('Date', [
        'displayAs' => function($result) {
          return date("M d Y", strtotime($result->date));
        }
      ])
      ->editColumn('Total', [
        'class' => 'right bold',
        'displayAs' => function($result) {
          return "P".number_format($result->total, 2);
        }
      ])
      ->showTotal([
        'Total' => 'point'
      ])
      ->setOrientation('portrait')
      // ->stream();
      ->download($filename);
  }

  /**
   *
   */
  public function _setReportsCriteria()
  {
    $criteria = new \stdClass;
    $models = [
      'areas' => 'App\Models\Area', 
      'activities' => 'App\Models\Activity', 
      'employees' => 'App\Models\Employee',
      'order_type' => 'App\Models\Order_Type'
    ];
    foreach ($models as $key => $model) {
      $criteria->$key = (new $model)->orderBy('name')
        ->pluck('name', 'id')
        ->prepend('-- All --', 0)
        ->toArray();
    }
    return $criteria;
  }

  /**
   * Calculate Tax
   */
  private function _calcTax($amount, $tax, $decimals = 2)
  {
    $calculatedAmount = ($amount * ($tax + 100)) / 100;
    return number_format($calculatedAmount, $decimals);
  }
}
