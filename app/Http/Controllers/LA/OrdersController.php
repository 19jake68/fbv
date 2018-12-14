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
use Collective\Html\FormFacade as Form;
use Datatables;
use DB;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
  public $show_action = true;
  public $view_col = 'job_number';
  public $listing_cols = ['id', 'job_number', 'team_leader', 'area_id', 'date', 'user_id', 'total'];

  public function __construct()
  {
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
      return redirect(config('laraadmin.adminRoute') . "/orders/" . $insert_id);
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
    if (Module::hasAccess("Orders", "create")) {
      $orderId = $request->order_id;
      $activityId = $request->activity_id;

      foreach ($request->items as $itemId => $item) {
        $quantity = (int) $item['quantity'];
        if (!$quantity) continue;
        $amount = (float) $item['amount'];
        $subtotal = (float) $quantity * $amount;

        $itemModel = new Item;
        $itemModel->createOrUpdate($orderId, $itemId, $activityId, $quantity, $item['measurement'], $item['unit'], $amount, $subtotal);
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
        $module->row = $order;
        $activities = Activity::lists('name', 'id');

        return view('la.orders.show', [
          'module' => $module,
          'view_col' => $this->view_col,
          'no_header' => true,
          'no_padding' => "no-padding",
          'activities' => $activities
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
      return redirect(config('laraadmin.adminRoute') . "/");
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

      return redirect()->route(config('laraadmin.adminRoute') . '.orders.index');

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

  /**
   * Datatable Ajax fetch
   *
   * @return
   */
  public function dtajax()
  {
    $values = DB::table('orders')->select($this->listing_cols)->whereNull('deleted_at');
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
        // else if($col == "author") {
        //    $data->data[$i][$j];
        // }
      }

      if ($this->show_action) {
        $output = '';
        if (Module::hasAccess("Orders", "edit")) {
          $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/orders/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
        }

        if (Module::hasAccess("Orders", "delete")) {
          $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.orders.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
          $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
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
  public function getItemDetailsByActivityId($id)
  {
    $order = Order::find($id);
    if (!isset($order->id)) return [];
    $model = Item_Detail::where('activity_id', $order->id)
      ->where('area_id', $order->area_id)
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
      $row->quantity = '<input style="width: 100px" type="number" name="items[' . $row->id . '][quantity]" class="quantity form-control input-sm" data-amount="' . $row->amount . '" data-id="' . $row->id . '" min="0">';
      $row->measurement = '<input style="width: 100px" type="text" name="items[' . $row->id . '][measurement]" class="form-control input-sm" >';
      $row->unit = '<select style="width: 100px" name="items[' . $row->id . '][unit]" class="form-control input-sm">' . $unitOptions . '</select>';
      $row->subtotal = '<input style="width: 100px" type="text" class="subtotal form-control input-sm text-right" readonly="true" value="Php 0.00" tabindex="-1"><input type="hidden" name="items[' . $row->id . '][amount]" value="' . $row->amount . '">';
    }
    return $model->toJson();
  }
}
