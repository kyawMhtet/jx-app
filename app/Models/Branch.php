<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'img',
        'branch_name',
        'phone',
        'address',
        'email',
        'formed_date',
        'is_default',
        'manager_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
