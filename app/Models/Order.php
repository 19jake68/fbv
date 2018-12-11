<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
class Order extends Model
{
  use SoftDeletes;
	
	protected $table = 'orders';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function items()
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

  public function listItems()
  {
    $items = Item::with('itemDetail', 'unit')
      ->select()
      ->where('order_id', $this->id)
      ->whereNull('deleted_at');
    $out = Datatables::of($items)->make();
    $data = $out->getData();
    return $data;
  }
}
