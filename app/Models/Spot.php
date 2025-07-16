<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Spot extends Model
{
    use HasFactory;
    protected $table = 'spots';
    protected $fillable = [
        'nama_spot',
        'lokasi',
        'latitude',
        'longitude',
        'deskripsi',
        'jenis_ikan',
        'gambar',
        'rekomendasi_umpan',
        'rekomendasi_cuaca',
        'harga_parkir',
        'status',
    ];
    public function umpans()
    {
        return $this->belongsToMany(Umpan::class, 'spot_umpan');
    }
    protected $casts = [
        'status' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'harga_parkir' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // PERBAIKAN: Tambahkan accessor untuk memastikan rekomendasi_umpan tidak null
    public function getRekomendasi_UmpanAttribute($value)
    {
        return $value ?: 'Tidak ada';
    }
    // PERBAIKAN: Tambahkan accessor untuk memastikan rekomendasi_cuaca tidak null
    public function getRekomendasi_CuacaAttribute($value)
    {
        return $value ?: 'Tidak ada';
    }

    // PERBAIKAN: Tambahkan accessor untuk harga_parkir
    public function getHarga_ParkirAttribute($value)
    {
        return $value ?: 'Gratis';
    }
}
