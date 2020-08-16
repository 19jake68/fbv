<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;

class Activity extends BaseModel
{
    // use SoftDeletes;

    protected $table = 'activities';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
