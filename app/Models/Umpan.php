<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umpan extends Model
{
    protected $table = 'umpans';

    protected $fillable = [
        'nama',
        'kategori',
        'jenis_ikan',
        'jenis_air',
        'waktu_terbaik',
        'deskripsi',
        'badge',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relasi many-to-many dengan model Spot
     */
    public function spots()
    {
        return $this->belongsToMany(Spot::class, 'spot_umpan');
    }
}
