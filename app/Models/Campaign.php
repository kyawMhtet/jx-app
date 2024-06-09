<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'shop_id',
        'post_id',
        'page_id',
        'is_live_sale',
        'title',
        'description',
        'channel_id',
        'branch_id',
        'status',
        'updated_by',
        'created_by'
    ];

    protected $appends = ["formatted_created_at", "campaign_channel_name"];

    public function campaign_items()
    {
        return $this->hasMany(CampaignItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    function getFormattedCreatedAtAttribute()
    {
        return date("Y-m-d H:i:s", strtotime($this->created_at));
    }


    public function sub_items()
    {
        return $this->belongsToMany(SubItem::class, CampaignItem::class, "campaign_id", "sub_item_id", "id");
    }

    public function getCampaignChannelNameAttribute()
    {
        $campaignChannelList = config('constants.campaignChannelList');
        return $campaignChannelList[$this->channel_id];
    }
}
