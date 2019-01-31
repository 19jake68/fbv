<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Detail extends BaseModel
{
  use SoftDeletes;
	
	protected $table = 'item_details';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function order()
  {
    return $this->belongsToMany('App\Models\Order');
  }

  public function item()
  {
    return $this->belongsTo('App\Models\Item');
  }

  public function area()
  {
    return $this->belongsTo('App\Models\Area', 'area_id');
  }

  public function activity()
  {
    return $this->belongsTo('App\Models\Acitivity', 'activity_id');
  }
}
