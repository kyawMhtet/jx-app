<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $table = "orders";
    // protected $guarded = [];
    protected $fillable = [
        // 'id',
        'order_number',
        'branch_id',
        'campaign_id',
        'customer_id',
        'item_count',
        'sub_total',
        'total',
        'payment_method',
        'discount',
        'tax',
        'charges',
        'name',
        'address',
        'phone',
        'note',
        'delivery_date',
        'delivery_name',
        'delivery_address',
        'delivery_phone',
        'order_date',
        'status'
    ];



    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class)->where("status", "active")->orwhere("status", "cancel");
    }
}
