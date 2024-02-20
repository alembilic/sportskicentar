<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function validFor(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::make($value)->format('F Y'),
            set: fn (string $value) => Carbon::make($value),
        );
    }

    public function setValidForAttribute($value)
    {
        $this->attributes['valid_for'] = Carbon::make($value);
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
