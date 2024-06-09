<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'img',
        'name',
        'phone',
        'address',
        'email',
        'formed_date',
        'status',
        'created_by',
        'updated_by'
    ];

    public function branch()
    {
        return $this->hasMany(Branch::class);
    }
}
