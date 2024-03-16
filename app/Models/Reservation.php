<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasClub;

    protected $guarded = ['id'];

    public function scopeIsAvailable($query, $start, $end)
    {
        return $query->where(function ($query) use ($start, $end) {
            $query->where(function ($query) use ($start, $end) {
                $query->where('start', '>=', $start)
                    ->where('start', '<', $end);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('end', '>', $start)
                    ->where('end', '<=', $end);
            });
        });
    }
}
