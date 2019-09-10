<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\Item;
use App\Models\Order_Misc;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends BaseModel
{
  // use SoftDeletes;
	
	protected $table = 'orders';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function orderItems()
  {
    return $this->hasMany('App\Models\Item');
  }

  public function orderMiscs()
  {
    return $this->belongsTo('App\Models\Order_Misc');
  }

  public function orderType()
  {
    return $this->belongsTo('App\Models\Order_Type');
  }

  public function area()
  {
    return $this->belongsTo('App\Models\Area');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\Employee');
  }

  public function calcTotalAmount($id) {
    $itemTotal = Item::where('order_id', $id)
      ->sum('subtotal');
    $miscTotal = Order_Misc::where('order_id', $id)
      ->sum('amount');
    $order =$this->where('id', $id)
      ->first();
    $order->total = $itemTotal + $miscTotal;
    return $order->save();
  }

  public static function checkUniqueJobNumberOnUpdate($jobNum, $id)
  {
    $model = Order::where('job_number', $jobNum);
    if ($model->count() > 1) return false;
    if ($model->count() == 1) return $model->first()->id == $id;
    return true;
  }
}
