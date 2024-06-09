<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignItem extends Model
{
    use HasFactory;

    protected $table = "campaign_items";
    protected $guarded = [];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function sub_item()
    {
        return $this->belongsTo(SubItem::class, "sub_item_id");
    }
}
