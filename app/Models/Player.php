<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
