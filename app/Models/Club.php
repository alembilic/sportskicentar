<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'slug', 'is_tenant', 'deleted_at'];

    public function players()
    {
        return $this->belongsTo(User::class);
    }
}
