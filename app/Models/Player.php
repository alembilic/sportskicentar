<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Player extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasClub, InteractsWithMedia;

    protected $guarded = ['id'];

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function selection(): BelongsTo
    {
        return $this->belongsTo(Selection::class);
    }

    public function dominantLeg()
    {
        return $this->belongsTo(Codebook::class, 'dominant_leg')->where('code_type', Codebook::DOMINANT_LEG);
    }

    public function educationLevel()
    {
        return $this->belongsTo(Codebook::class, 'level_of_education')->where('code_type', Codebook::LEVEL_OF_EDUCATION);
    }

    public function educationStatus()
    {
        return $this->belongsTo(Codebook::class, 'education_status')->where('code_type', Codebook::EDUCATION_STATUS);
    }

    public function educationInstitution()
    {
        return $this->belongsTo(Codebook::class, 'education_institution')->where('code_type', Codebook::EDUCATION_INSTITUTION);
    }

    public function gearSize()
    {
        return $this->belongsTo(Codebook::class, 'gear_size')->where('code_type', Codebook::GEAR_SIZE);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(80)
            ->height(80);
    }

    public function pastThreeMemberships()
    {
        return $this->hasMany(Membership::class)
            ->whereBetween('valid_for', [Carbon::now()->subMonths(2)->month, Carbon::now()->month])
            ->where('paid', 1);
    }
}
