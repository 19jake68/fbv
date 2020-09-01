<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;

class Employee extends BaseModel
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

    public function employeeCompany()
    {
        return $this->belongsTo('App\Models\Company', 'company');
    }

    public function employeeActivityType()
    {
        return $this->belongsTo('App\Models\Activity_Type', 'activity_type');
    }
}
