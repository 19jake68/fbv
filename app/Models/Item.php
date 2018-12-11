<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
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
    return $this->belongsTo('App\Models\Item_Detail')->select('id', 'name', 'amount');
  }

  public function unit()
  {
    return $this->belongsTo('App\Models\Unit')->select('id', 'unit');
  }
}
