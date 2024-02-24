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

    protected function codeType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => self::getOptions()[$value],
        );
    }

    public static function getOptions(): array
    {
        return [
            1 => 'Lige',
            2 => 'Kategorije',
            3 => 'Selekcije'
        ];
    }
}
