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

    public function calcTotalAmount($id)
    {
        $itemTotal = Item::where('order_id', $id)
            ->sum('subtotal');
        $miscTotal = Order_Misc::where('order_id', $id)
            ->sum('amount');
        $order = $this->where('id', $id)
            ->first();
        $order->total = $itemTotal + $miscTotal;
        return $order->save();
    }

    public function setTaxDetails($id)
    {
        $order = $this->where('id', $id)
            ->first();

        if ($order->has_tax) {
            $itemModel = new Item;
            $taxDetails = $itemModel->getTaxDetails($id);
            $order->taxable_amount = $taxDetails['taxable'];
            $order->tax_exempt_amount = $taxDetails['taxExempt'];
            $order->total_tax_amount = $taxDetails['totalTax'];
        } else {
            $order->taxable_amount = 0;
            $order->tax_exempt_amount = 0;
            $order->total_tax_amount = 0;
        }

        // dd($order);

        return $order->save();
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
