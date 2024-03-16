<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes, HasClub;

    protected $guarded = ['id'];

    protected function validFor(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::make($value)->format('Y-m'),
            set: fn(string $value) => Carbon::make($value),
        );
    }

    protected static function booted(): void
    {
        static::creating(function (Membership $membership) {
            $membership->club_id = auth()->user()->club_id;
            $membership->price = MembershipType::where('id', $membership->membership_type_id)->first()->price;
        });
    }

    public function player(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function membershipType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MembershipType::class);
    }
}
