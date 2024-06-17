<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'shop_id',
        'item_name',
        'unit',
        'stock',
        'short_description',
        'description',
        'status',
        'image_url',
        'created_by',
        'updated_by'
    ];

    protected $hidden = ["created_at", "updated_at"];
    protected $appends = ["formatted_created_at"];

    public function sub_items()
    {
        return $this->hasMany(SubItem::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
