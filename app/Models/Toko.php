<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'tokos';

    protected $fillable = [
        'nama',
        'alamat',
        'latitude',
        'longitude',
        'deskripsi',
        'gambar',
        'no_telp',
        'jam_buka',
        'jam_tutup',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    protected $appends = ['is_open', 'status_text'];

    /**
     * Get status buka/tutup toko berdasarkan jam operasional
     */
    public function getIsOpenAttribute()
    {
        if (!$this->status) {
            return false;
        }

        $now = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $jamBuka = $this->jam_buka;
        $jamTutup = $this->jam_tutup;

        // Jika jam tutup lebih kecil dari jam buka (melewati tengah malam)
        if ($jamTutup < $jamBuka) {
            return $now >= $jamBuka || $now <= $jamTutup;
        }

        return $now >= $jamBuka && $now <= $jamTutup;
    }

    /**
     * Get status text buka/tutup
     */
    public function getStatusTextAttribute()
    {
        if (!$this->status) {
            return 'Tidak Aktif';
        }
        return $this->is_open ? 'Buka' : 'Tutup';
    }
}
