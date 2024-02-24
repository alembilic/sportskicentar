<?php

namespace App\Models;

use App\Models\Traits\HasClub;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Codebook extends Model
{
    use HasFactory, SoftDeletes, HasClub;

    protected $guarded = ['id'];
    const LEAGUE = 1;
    const CATEGORY = 2;
    const LICENCE = 3;
    const GEAR_SIZE = 4;

    protected function codeType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => self::getOptions()[$value],
        );
    }

    public static function getOptions(): array
    {
        return [
            self::LEAGUE => 'Liga',
            self::CATEGORY => 'Kategorija',
            self::LICENCE => 'Licenca',
            self::GEAR_SIZE => 'Veličina opreme'
        ];
    }
}
