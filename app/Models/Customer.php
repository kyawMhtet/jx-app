<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $hidden = ["updated_at"];
    protected $appends = ["formatted_created_at"];
    protected $fillable = [
        'id',
        'channel_customer_id',
        'channel_id',
        'branch_id',
        'gender',
        'birthday',
        'customer_name',
        'email',
        'phone',
        'shipping_address',
        'contact',
        'profile_pic_url',
        'status'
    ];

    function getFormattedCreatedAtAttribute()
    {
        return date("Y-m-d H:i:s", strtotime($this->created_at));
    }
}
