<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;

class Activity_Type extends BaseModel
{
    // use SoftDeletes;

    protected $table = 'activity_types';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
