<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasClub;

    protected $guarded = ['id'];
}
