<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory, HasClub;

    protected $guarded = ['id'];

    public function gearSize()
    {
        return $this->belongsTo(Codebook::class, 'gear_size')->where('code_type', Codebook::GEAR_SIZE);
    }
}
