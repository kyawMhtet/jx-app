<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'item_id',
        'sku',
        'sub_item_name',
        'attribute_name',
        'attribute_value',
        'color',
        'size',
        'model',
        'other',
        'price',
        'stock',
        'image_url',
        'status',
        'inventory_code'
    ];
    protected $hidden = ["created_at", "updated_at"];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
