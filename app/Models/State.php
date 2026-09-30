<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'capital',
        'region',
        'lga_count',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude'  => 'decimal:7',
            'longitude' => 'decimal:7',
            'lga_count' => 'integer',
        ];
    }

    public function lgas()
    {
        return $this->hasMany(Lga::class);
    }
}