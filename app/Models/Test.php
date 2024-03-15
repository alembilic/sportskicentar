<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, HasClub, SoftDeletes;

    protected $guarded = ['id'];

    public function testType()
    {
        return $this->belongsTo(Codebook::class, 'test_type')->where('code_type', Codebook::TEST_TYPE);
    }

    public function player(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
