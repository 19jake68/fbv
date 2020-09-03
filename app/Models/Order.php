<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Item;
use App\Models\Order_Misc;

class Order extends BaseModel
{
    // use SoftDeletes;

    protected $table = 'orders';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function orderItems()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function orderMiscs()
    {
        return $this->belongsTo('App\Models\Order_Misc');
    }

    public function orderType()
    {
        return $this->belongsTo('App\Models\Order_Type');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function otMultiplier()
    {
        return $this->hasMany('App\Models\Overtime_Multiplier');
    }

    public function calcTotalAmount($id)
    {
        $itemTotal = Item::where('order_id', $id)
            ->sum('subtotal');
        $miscTotal = Order_Misc::where('order_id', $id)
            ->sum('amount');
        $order = $this->where('id', $id)
            ->first();
        $order->total = round($itemTotal + $miscTotal, 2);

        // OT Multiplier
        if (count(json_decode($order->ot_multiplier))) {
            $order->ot_multiplier_amount = round($order->total * ($order->ot_multiplier_value), 2);
        } else {
            $order->ot_multiplier_amount = 0;
        }

        // Tax
        if ($order->has_tax && $order->tax > 0) {
            $order->taxable_amount = $order->total;
            $order->ot_multiplier_tax = round($order->ot_multiplier_amount * ($order->tax / 100), 2);
            $order->total_tax_amount = round($order->total * ($order->tax / 100), 2);
        } else {
            $order->taxable_amount = 0;
            $order->ot_multiplier_tax = 0;
            $order->total_tax_amount = 0;
        }

        $order->save();
        return $order;
    }

    public static function checkUniqueJobNumberOnUpdate($jobNum, $id)
    {
        $model = Order::where('job_number', $jobNum);
        if ($model->count() > 1) {
            return false;
        }

        if ($model->count() == 1) {
            return $model->first()->id == $id;
        }

        return true;
    }
}
