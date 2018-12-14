<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends BaseModel
{
    use SoftDeletes;
	
	protected $table = 'items';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function order()
  {
    return $this->belongsTo('App\Models\Order');
  }

  public function itemDetail()
  {
    return $this->belongsTo('App\Models\Item_Detail', 'item_detail_id', 'id')->select('id', 'name', 'amount');
  }

  public function unit()
  {
    return $this->hasOne('App\Models\Unit', 'unit_id', 'id')->select('id', 'unit');
  }

  public function activity()
  {
    return $this->hasOne('App\Models\Activity', 'id', 'activity_id')->select('id', 'name');
  }

  public function createOrUpdate($orderId, $itemId, $activityId, $quantity, $measurement, $unit, $amount, $subtotal)
  {
    $model = $this->where('order_id', $orderId)
      ->where('item_detail_id', $itemId)
      ->first();

    if ($model) {
      $model->quantity = $quantity;
      $model->measurement = $measurement;
      $model->unit_id = $unit;
      $model->amount = $amount;
      $model->subtotal = $subtotal;
      return $model->save();
    } else {
      return $this->create([
        'order_id' => $orderId,
        'item_detail_id' => $itemId,
        'activity_id' => $activityId,
        'measurement' => $measurement,
        'unit_id' => $unit,
        'quantity' => $quantity,
        'amount' => $amount,
        'subtotal' => $subtotal,
      ]);
    }
  }
}
