<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankInfo extends Model
{
    use HasFactory;

    protected $table = 'bankinfos';

    protected $fillable = [
        'user_id',
        'branch_id',
        'bank_name',
        'account_name',
        'account_no',
        'qr_img',
        'status'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}
