<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_Type extends BaseModel
{
    // use SoftDeletes;
	
	protected $table = 'order_types';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function orders()
	{
		return $this->belongsToMany('App\Models\Order');
	}
}
