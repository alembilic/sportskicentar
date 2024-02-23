<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Club extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id', 'slug', 'is_tenant', 'deleted_at'];

    public function players()
    {
        return $this->belongsTo(Player::class);
    }
}
