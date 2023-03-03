<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'final_price',
        'user_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
            $model->created_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function historyAuctions()
    {
        return $this->hasMany(HistoryAuction::class, 'auction_id', 'id');
    }

    public function lastAuction()
    {
        return $this->hasOne(HistoryAuction::class, 'auction_id', 'id')->latest();
    }
}
