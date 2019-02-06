<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\Item;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
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

  public function area()
  {
    return $this->belongsTo('App\Models\Area');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function calcTotalAmount($id) {
    $total = Item::where('order_id', $id)
      ->sum('subtotal');
    $order =$this->where('id', $id)
      ->first();
    $order->total = $total;
    return $order->save();
  }
}
