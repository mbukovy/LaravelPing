<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    protected $fillable = [
        'uuid',
        'battery_percent',
    ];

    protected function casts(): array
    {
        return [
            'battery_percent' => 'integer',
        ];
    }
}
