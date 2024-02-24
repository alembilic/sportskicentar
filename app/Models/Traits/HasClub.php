<?php

namespace App\Models\Traits;

use App\Models\Club;
use App\Models\Scopes\ClubScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasClub
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ClubScope());

        static::creating(function ($model) {
            $model->club_id = auth()->user()->club_id;
        });
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
