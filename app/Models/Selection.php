<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory, HasClub;

    protected $guarded = ['id'];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function category()
    {
        return $this->belongsTo(Codebook::class, 'category_id')->where('code_type', Codebook::CATEGORY);
    }

    public function league()
    {
        return $this->belongsTo(Codebook::class, 'league_id')->where('code_type', Codebook::LEAGUE);
    }
}
