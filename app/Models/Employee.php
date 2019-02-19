<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    // use SoftDeletes;
	
	protected $table = 'employees';
	
	protected $hidden = [];

	protected $guarded = [];

  protected $dates = ['deleted_at'];
  
  public function areas()
  {
    return $this->belongsTo('App\Models\Area', 'areas');
  }

  public function user()
  {
    return $this->hasOne('App\User', 'context_id', 'id');
  }
}
