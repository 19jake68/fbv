<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends BaseModel
{
    use SoftDeletes;
	
	protected $table = 'units';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function items()
  {
    return $this->hasMany('App\Models\Item');
  }
}
