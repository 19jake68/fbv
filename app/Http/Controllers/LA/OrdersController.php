<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Helpers\FBV\Invoice;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Activity_Type;
use App\Models\Area;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Item_Detail;
use App\Models\Order;
use App\Models\Order_Type;
use App\Models\Overtime_Multiplier;
use App\Models\Unit;
use Auth;
use Carbon\Carbon;
use Collective\Html\FormFacade as Form;
use Datatables;
use DB;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use ExcelReport;
use Illuminate\Http\Request;
use PdfReport;
use Validator;

class OrdersController extends Controller
{
    public $show_action;
    public $view_col = 'job_number';
    public $vista_view_col = 'meter_no';
    public $listing_cols = ['id', 'job_number', 'company', 'order_type_id', 'account_name', 'area_id', 'date', 'user_id', 'total', 'has_tax'];
    public $vista_listing_cols = ['id', 'meter_no', 'company', 'order_type_id', 'area_id', 'date', 'user_id', 'total'];
    public $order_items_cols = ['id', 'activity', 'item', 'amount', 'quantity', 'unit', 'subtotal', 'remarks', 'has_tax', 'tax'];
    public $displayTaxPerItem = false;
    public $hasOTMultiplier = false;
    public $activityType;
    public $activityTypeLabel;
    public $isActivityTypeVista;

    public function __construct()
    {
        parent::__construct();
        // Field Access of Listing Columns
        if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
            $this->middleware(function ($request, $next) {
                if ($this->isActivityTypeVista) {
                    $this->vista_listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->vista_listing_cols);
                } else {
                    $this->listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->listing_cols);
                }

                return $next($request);
            });
        } else {
            if ($this->isActivityTypeVista) {
                $this->vista_listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->vista_listing_cols);
            } else {
                $this->listing_cols = ModuleFields::listingColumnAccessScan('Orders', $this->listing_cols);
            }

        }

        $this->show_action = Module::hasAccess("Orders", "edit") || Module::hasAccess("Orders", "delete");

        $employee = Auth::user()->employee;
        $this->activityType = $employee->activity_type;
        $this->activityTypeLabel = $employee->employeeActivityType->activity_type;
        $this->isActivityTypeVista = $this->activityType === 2;
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
            $orderType = Order_Type::whereNull('deleted_at')->where('id', '!=', 1)->lists('name', 'id');
            $areaModel = new Area;
            $areaModel = $areaModel->where('id', '!=', 1)->whereNull('deleted_at');

            if (!$this->isAdmin) {
                $userAreas = Auth::user()->employee()->first()->areas;
                $userAreas = json_decode($userAreas);
                $areaModel = $areaModel->whereIn('id', $userAreas);
            }

            $params = [
                'show_actions' => $this->show_action,
                'listing_cols' => $this->isActivityTypeVista ? $this->vista_listing_cols : $this->listing_cols,
                'module' => $module,
                'orderType' => $orderType,
                'areas' => $areaModel->lists('name', 'id'),
                'reports' => $this->isAdmin ? $this->_setReportsCriteria() : null,
                'showUserColumn' => $this->isAdmin ? false : false,
                'activityTypeLabel' => $this->activityTypeLabel,
                'isActivityTypeVista' => $this->isActivityTypeVista,
            ];

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
            if ($this->isActivityTypeVista) {
                $rules['date'] = 'required';
                $rules['subdivision'] = 'required';
                $rules['block'] = 'required';
                $rules['lot'] = 'required';
                $rules['meter_no'] = 'unique:orders|required|max:255';
            } else {
                $rules['job_number'] = 'unique:orders|required|max:255';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($this->isActivityTypeVista) {
                $request->job_number = 'METNO' . $request->meter_no;
            } else {
                // Set today's date
                $request->merge([
                    'date' => Carbon::today()->format('d/m/Y'),
                ]);
            }

            // Get OT Multiplier Value
            if ($request->ot_multiplier) {
                $otMulti = $this->_getOTMultiValue($request->ot_multiplier);
                $request->ot_multiplier_text = $otMulti->text;
                $request->ot_multiplier_value = $otMulti->value;
            }

            // Add activity type
            $request->activity_type = $this->activityType;

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
                if ($item['quantity'] === '' || $item['quantity'] <= 0) {
                    continue;
                }

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
            $newOrderData = $order->calcTotalAmount($orderId);

            if ($request->get('ajax') !== null) {
                return response()->json(['order' => $newOrderData]);
            }

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
                $activities = Activity::where('type', Auth::user()->employee->activity_type)->lists('name', 'id');
                $this->hasOTMultiplier = !!count(json_decode($order->ot_multiplier));

                // Format dates
                $order->date = Carbon::parse($order->date)->format('M d, Y g:i a');
                $order->time_start = !empty($order->time_start)
                ? Carbon::parse($order->time_start)->format('M d, Y g:i a')
                : '--';
                $order->time_finished = !empty($order->time_finished)
                ? Carbon::parse($order->time_finished)->format('M d, Y g:i a')
                : '--';

                // Get company based on user's details
                $order->company = $this->_getCompanyByEmployee($order);

                return view('la.orders.show', [
                    'module' => $module,
                    'view_col' => $this->isActivityTypeVista ? $this->vista_view_col : $this->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    'activities' => $activities,
                    'items_cols' => $this->order_items_cols,
                    'hasOTMultiplier' => $this->hasOTMultiplier,
                    'isActivityTypeVista' => $this->isActivityTypeVista,
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
                    'orderType' => $orderType,
                    'order' => $order,
                    'isActivityTypeVista' => $this->isActivityTypeVista,
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

            // add custom rule
            if ($this->isActivityTypeVista) {
                $rules['date'] = 'required';
                $rules['subdivision'] = 'required';
                $rules['block'] = 'required';
                $rules['lot'] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);
            $validator->after(function ($validator) use ($request, $id) {
                if (!Order::checkUniqueJobNumberOnUpdate($request->job_number, $id)) {
                    $validator->errors()->add('job_number', 'The job number has already been taken.');
                }
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->ot_multiplier) {
                $otMulti = $this->_getOTMultiValue($request->ot_multiplier);
                $request->ot_multiplier_text = $otMulti->text;
                $request->ot_multiplier_value = $otMulti->value;
            } else {
                $request->ot_multiplier = [];
                $request->ot_multiplier_text = '';
                $request->ot_multiplier_value = 0;
            }

            $insert_id = Module::updateRow("Orders", $request, $id);
            $model = new Order;
            $model->calcTotalAmount($id);
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
            ->whereNull('item_detail.deleted_at')
            ->orderBy('activity.id', 'ASC')
            ->orderBy('item_detail.id', 'ASC');

        $out = Datatables::of($values)->make();
        $data = $out->getData();

        // Get units
        $units = Unit::all();

        $itemFields = Module::get('Items')->fields;
        $quantityMinLength = $itemFields['quantity']['minlength'];

        $items = [];
        foreach ($data->data as $orderItem) {
            $_id = $orderItem[0];
            $_activity = $orderItem[1];
            $_name = $orderItem[2];
            $_amount = $orderItem[3];
            $_quantity = $orderItem[4];
            $_unit = $orderItem[5];
            $_subtotal = (float) $orderItem[6];
            $_remarks = $orderItem[7];
            $_hasTax = $orderItem[8];
            $_tax = $orderItem[9];

            if (Module::hasAccess('Items', 'edit')) {
                $hasTax = $orderModel->has_tax && $_hasTax;

                if ($this->displayTaxPerItem) {
                    // Amount
                    if ($hasTax) {
                        $orderItem[3] = $this->_calcTax($_amount, $_tax);
                        $_amount = $orderItem[3];
                    }

                    // Quantity
                    $orderItem[4] = '<input type="number" step="0.01" value="' . $_quantity . '" class="quantity form-control input-sm inline-edit disabled" min="' . $quantityMinLength . '" style="width:100%" data-tax="' . $_tax . '" data-has-tax="' . $_hasTax . '" data-amount="' . $_amount . '" data-type="quantity" data-id="' . $_id . '">';
                } else {
                    $orderItem[4] = '<input type="number" step="0.01" value="' . $_quantity . '" class="quantity form-control input-sm inline-edit disabled" min="' . $quantityMinLength . '" style="width:100%" data-amount="' . $_amount . '" data-type="quantity" data-id="' . $_id . '">';
                }

                // Unit
                $options = '';
                for ($j = 0; $j < count($units); $j++) {
                    $options .= $_unit === $units[$j]->unit
                    ? '<option selected value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>'
                    : '<option value="' . $units[$j]->id . '">' . $units[$j]->unit . '</option>';
                }
                $orderItem[5] = '<select class="form-control input-sm inline-edit disabled" style="width:100%" data-type="unit" data-id="' . $_id . '">' . $options . '</select>';

                // Subtotal
                $orderItem[6] = ($hasTax) ? $_amount * $_quantity : $_subtotal;

                // Remarks
                $orderItem[7] = '<textarea class="form-control input-sm inline-edit disabled" data-type="remarks" data-id="' . $_id . '" style="resize:vertical;min-height:27px;width:100%">' . $_remarks . '</textarea>';
            }

            $output = '';
            if (Module::hasAccess('Items', 'delete')) {
                $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.items.destroy', $_id], 'method' => 'delete', 'style' => 'display:inline']);
                $output .= ' <button class="btn btn-danger btn-xs item-delete" type="submit"><i class="fa fa-times"></i></button>';
                $output .= Form::close();
            }
            $orderItem[] = $output;

            array_push($items, $orderItem);
        }

        $data->data = $items;
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
        if ($this->isActivityTypeVista) {
            $select = ['orders.id', 'meter_no', 'companies.name as company', 'order_types.name as order_type', 'area_id', 'date', 'employees.name', 'total'];
        } else {
            $select = ['orders.id', 'job_number', 'companies.name as company', 'order_types.name as order_type', 'account_name', 'area_id', 'date', 'employees.name', 'total', 'has_tax'];
        }

        $values = DB::table('orders')
            ->leftJoin(Employee::getTableName() . ' AS employees', 'employees.id', '=', 'orders.user_id')
            ->leftJoin(Company::getTableName() . ' AS companies', 'companies.id', '=', 'employees.company')
            ->leftJoin(Order_Type::getTableName() . ' AS order_types', 'order_types.id', '=', 'orders.order_type_id')
            ->select($select)
            ->whereNull('orders.deleted_at');

        // List user created order if not admin, otherwise display all orders
        // if (!$this->isAdmin) {
        $values->where('user_id', Auth::user()->id);
        // }
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        $fields_popup = ModuleFields::getModuleFields('Orders');

        for ($i = 0; $i < count($data->data); $i++) {
            // Calculate Tax
            if (!$this->isActivityTypeVista) {
                if ($data->data[$i][9]) { // has tax
                    $data->data[$i][8] += round($data->data[$i][8] * (env('TAX') / 100), 2);
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
            } else {
                for ($j = 0; $j < count($this->vista_listing_cols); $j++) {
                    $col = $this->vista_listing_cols[$j];
                    if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                        $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                    }
                    if ($col == $this->vista_view_col) {
                        $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/orders/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                    }
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
        $model = DB::table(Item_Detail::getTableName() . ' AS item_detail')
            ->where('activity_id', $request->id)
            ->where('area_id', $request->areaId)
            ->whereNull('item_detail.deleted_at')
            ->orderBy('item_detail.id', 'ASC');

        if ($request->search) {
            $model->where('item_detail.name', 'like', '%' . $request->search . '%');
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
            $row->amount = $order->has_tax && $this->displayTaxPerItem ? $this->_calcTax($row->amount, $order->tax) : $row->amount;
            $row->quantity = '<input style="width: 100px" type="number" step=".01" value="0" name="items[' . $row->id . '][quantity]" class="quantity form-control input-sm" data-taxed-amount="' . $row->amount . '" data-amount="' . $amount . '" data-id="' . $row->id . '" min="' . $quantityMinLength . '">';
            $row->unit = '<select style="width: 100px" name="items[' . $row->id . '][unit]" class="form-control input-sm">' . $unitOptions . '</select>';
            $row->subtotal = '<span class="subtotal">₱0.00</span><input type="hidden" name="items[' . $row->id . '][amount]" value="' . $amount . '">';
            $row->remarks = '<textarea style="resize: vertical;min-height:27px"name="items[' . $row->id . '][remarks]" class="form-control input-sm"></textarea>';
        }
        return $model;
    }

    public function editItems(Request $request)
    {
        $hasModifications = false;
        $newOrderData = null;
        // Update quantity
        if ($request->get('quantity')) {
            $minlength = (int) Module::get('Items')->fields['quantity']['minlength'];
            array_map(function ($value, $id) use ($request, $minlength) {
                if ($value < $minlength) {
                    return;
                }

                $item = Item::find($id);
                $item->quantity = (float) $value;
                $item->subtotal = $item->amount * $value;
                $item->save();
            }, $request->get('quantity'), array_keys($request->get('quantity')));
            $hasModifications = true;
        }

        // Update unit
        if ($request->get('unit')) {
            array_map(function ($value, $id) {
                $item = Item::find($id);
                $item->unit_id = (int) $value;
                $item->save();
            }, $request->get('unit'), array_keys($request->get('unit')));
            $hasModifications = true;
        }

        // Remarks
        if ($request->get('remarks')) {
            array_map(function ($value, $id) {
                $item = Item::find($id);
                $item->remarks = $value;
                $item->save();
            }, $request->get('remarks'), array_keys($request->get('remarks')));
            $hasModifications = true;
        }

        $order = new Order;
        $newOrderData = $order->calcTotalAmount($request->get('orderId'));

        return response()->json(['has_modifications' => $hasModifications, 'order' => $newOrderData]);
    }

    public function generateInvoice(Request $request)
    {
        if (Module::hasAccess("Orders", "view")) {
            $order = Order::find($request->id);
            $this->hasOTMultiplier = !!count(json_decode($order->ot_multiplier));

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
                    ->business(['name' => $this->_getCompanyByEmployee($order)])
                    ->biller(['name' => $order->user->name, 'email' => $order->user->email])
                    ->customer(['name' => $order->account_name])
                    ->number($this->isActivityTypeVista ? $order->meter_no : $order->job_number)
                    ->area($order->area->name)
                    ->dateDone(date("M j, Y"))
                    ->timeStart($timeStart)
                    ->timeEnd($timeEnd)
                    ->totalInvoice($order->total)
                    ->hasTax($order->has_tax)
                    ->displayTax(true)
                    ->subtotal($order->total)
                    ->taxAmount($order->total_tax_amount)
                    ->hasOTMultiplier($this->hasOTMultiplier)
                    ->otMultiplierText($order->ot_multiplier_text)
                    ->otMultiplierAmount($order->ot_multiplier_amount)
                    ->otMultiplierTax($order->ot_multiplier_tax)
                    ->notes($order->remarks)
                    ->currency('₱');

                if ($this->isActivityTypeVista) {
                    $invoice->subdivision($order->subdivision)
                        ->block($order->block)
                        ->lot($order->lot);
                }

                // Items
                $items = Item::leftJoin(Item_Detail::getTableName() . ' as item_detail', 'item_detail_id', '=', 'item_detail.id')
                    ->leftJoin(Unit::getTableName() . ' as unit', 'unit_id', '=', 'unit.id')
                    ->leftJoin(Activity::getTableName() . ' as activity', 'items.activity_id', '=', 'activity.id')
                    ->select('activity.name as activity_name', 'items.id', 'item_detail.name', 'items.quantity', 'items.amount', 'unit.unit', 'items.remarks', 'items.activity_id', 'items.has_tax', 'items.tax')
                    ->where('order_id', '=', $order->id)
                    ->where('items.activity_id', '<>', 11)
                    ->whereNull('items.deleted_at')
                    ->whereNull('item_detail.deleted_at')
                    ->orderBy('activity.id', 'ASC')
                    ->orderBy('items.id', 'ASC')
                    ->get();

                $groupedItems = [];
                foreach ($items as $index => $item) {
                    if ($order->has_tax && $item->has_tax && $this->displayTaxPerItem) {
                        $item->amount = $this->_calcTax($item->amount, $item->tax);
                    }

                    $totalPrice = number_format(bcmul($item->amount, $item->quantity, $invoice->decimals), $invoice->decimals);
                    $item->totalPrice = $invoice->currency . $totalPrice;
                    $groupedItems[$item->activity_name][] = $item;
                }

                $invoice->addGroupedItems($groupedItems);

                $others = Item::leftJoin(Item_Detail::getTableName() . ' as item_detail', 'item_detail_id', '=', 'item_detail.id')
                    ->leftJoin(Unit::getTableName() . ' as unit', 'unit_id', '=', 'unit.id')
                    ->select('items.id', 'item_detail.name', 'items.quantity', 'items.subtotal', 'unit.unit', 'items.remarks', 'items.has_tax', 'items.tax')
                    ->where('order_id', '=', $order->id)
                    ->where('items.activity_id', '=', 11)
                    ->whereNull('items.deleted_at')
                    ->whereNull('item_detail.deleted_at')
                    ->orderBy('items.id', 'ASC')
                    ->get();

                foreach ($others as $index => $item) {
                    $invoice->addMisc($item->name, $item->quantity, $item->unit, $item->subtotal, $item->remarks, $order->has_tax && $item->has_tax && $this->displayTaxPerItem, $item->tax);
                }

                $invoiceParams = [
                    'invoice' => $invoice,
                ];

                if ($this->isActivityTypeVista) {
                    return View('vendor.invoices.fbv-vista', $invoiceParams);
                } else {
                    return View('vendor.invoices.fbv', $invoiceParams);
                }
            }
        }
    }

    public function generateReportV2(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $$key = $value;
        }

        $title = 'Order Report';
        $meta = [
            'Covered Date' => date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)),
            'Order Type' => 'All',
            'Activity' => 'All',
            'Area' => 'All',
        ];

        $columns = [
            'Job #' => 'job_number',
            'Order Type' => 'order_type',
            // 'Company' => 'company',
            'Account Name' => 'account_name',
            // 'Area' => 'area',
            'Billed By' => 'employee',
            'Date' => 'date',
            'Total' => 'total',
        ];

        if ($activityId) {
            $query = Order::select('company.name as company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'), 'activity.name');
        } else {
            $query = Order::select('company.name as company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'));
        }

        $query->leftJoin(Area::getTableName() . ' as area', 'area.id', '=', 'area_id')
            ->leftJoin(Employee::getTableName() . ' as user', 'user.id', '=', 'user_id')
            ->leftJoin(Item::getTableName() . ' as item', 'item.order_id', '=', 'orders.id')
            ->leftJoin(Company::getTableName() . ' as company', 'company.id', '=', 'user.company')
            ->leftJoin(Order_Type::getTableName() . ' as order_type', 'order_type.id', '=', 'orders.order_type_id')
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('item.order_id')
            ->orderBy('date', 'desc');

        return ExcelReport::of($title, $meta, $query, $columns, [])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'Total Balance' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->limit(20) // Limit record to be showed
            ->download('download.xlsx'); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function generateReport(Request $request)
    {
        return $this->generateReportV2($request);
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
            'Area' => 'All',
        ];
        $footer = [
            'Prepared by' => $loggedInPersonnel . ' (' . $dateTimeGenerated . ')',
            'Approved by' => $adminModel ? $adminModel->name : 'N/A',
        ];
        $columns = [
            'Job #' => 'job_number',
            'Order Type' => 'order_type',
            // 'Company' => 'company',
            'Account Name' => 'account_name',
            // 'Area' => 'area',
            'Billed By' => 'employee',
            'Date' => 'date',
            'Total' => 'total',
        ];

        if ($activityId) {
            $query = Order::select('company.name as company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'), 'activity.name');
        } else {
            $query = Order::select('company.name as company', 'order_type.name as order_type', 'job_number', 'account_name', 'area.name as area', 'user.name as employee', 'date', DB::raw('SUM(subtotal) as total'));
        }

        $query->leftJoin(Area::getTableName() . ' as area', 'area.id', '=', 'area_id')
            ->leftJoin(Employee::getTableName() . ' as user', 'user.id', '=', 'user_id')
            ->leftJoin(Item::getTableName() . ' as item', 'item.order_id', '=', 'orders.id')
            ->leftJoin(Company::getTableName() . ' as company', 'company.id', '=', 'user.company')
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
            $footer['Billed By'] = $user->name;
            unset($columns['Billed By']);
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

        return PdfReport::of($title, $meta, $query, $columns, $footer)
            ->editColumn('Date', [
                'displayAs' => function ($result) {
                    return date("M d Y", strtotime($result->date));
                },
            ])
            ->editColumn('Total', [
                'class' => 'right bold',
                'displayAs' => function ($result) {
                    return "P" . number_format($result->total, 2);
                },
            ])
            ->showTotal([
                'Total' => 'point',
            ])
            ->setOrientation('portrait')
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
            'order_type' => 'App\Models\Order_Type',
        ];

        $criteria->activity_type = Activity_Type::orderBy('activity_type')
            ->pluck('activity_type', 'id')
            ->toArray();

        foreach ($models as $key => $model) {
            $criteria->$key = (new $model)->orderBy('name')
                ->pluck('name', 'id')
                ->prepend('-- All --', 0)
                ->toArray();
        }
        return $criteria;
    }

    /**
     * Get OT Multipler values
     */
    private function _getOTMultiValue($otMultiArr)
    {
        $orderOTMuli = Overtime_Multiplier::whereIn('id', $otMultiArr)->get();
        $obj = new \stdClass();
        $orderStr = [];
        $orderVal = 0;

        for ($i = 0; $i < count($orderOTMuli); $i++) {
            $otMulti = $orderOTMuli[$i];
            $orderVal += $otMulti->value;
            array_push($orderStr, $otMulti->type);
        }

        $obj->text = implode(' + ', $orderStr);
        $obj->value = $orderVal;

        return $obj;
    }

    /**
     * Calculate Tax
     */
    private function _calcTax($amount, $tax, $decimals = 2)
    {
        $amount = (float) $amount;
        $calculatedAmount = ($amount * ($tax + 100)) / 100;
        return (float) number_format($calculatedAmount, $decimals, '.', '');
    }

    private function _getCompanyByEmployee($model)
    {
        return $model->user->employeeCompany()->first()->name;
    }
}
