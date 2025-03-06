<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus tabel jika sudah ada
        Schema::dropIfExists('spot_umpan');

        // Dapatkan tipe data kolom id dari tabel spots
        $spotsIdType = DB::select("SHOW COLUMNS FROM spots WHERE Field = 'id'")[0]->Type;

        // Dapatkan tipe data kolom id dari tabel umpans
        $umpansIdType = DB::select("SHOW COLUMNS FROM umpans WHERE Field = 'id'")[0]->Type;

        // Buat tabel baru tanpa foreign key constraints terlebih dahulu
        Schema::create('spot_umpan', function (Blueprint $table) use ($spotsIdType, $umpansIdType) {
            $table->id();

            // Gunakan tipe data yang sama dengan tabel spots untuk spot_id
            if (strpos($spotsIdType, 'int') !== false) {
                if (strpos($spotsIdType, 'bigint') !== false) {
                    $table->unsignedBigInteger('spot_id');
                } else if (strpos($spotsIdType, 'smallint') !== false) {
                    $table->unsignedSmallInteger('spot_id');
                } else {
                    $table->unsignedInteger('spot_id');
                }
            } else {
                $table->unsignedBigInteger('spot_id'); // Default jika tidak bisa dideteksi
            }

            // Gunakan tipe data yang sama dengan tabel umpans untuk umpan_id
            if (strpos($umpansIdType, 'int') !== false) {
                if (strpos($umpansIdType, 'bigint') !== false) {
                    $table->unsignedBigInteger('umpan_id');
                } else if (strpos($umpansIdType, 'smallint') !== false) {
                    $table->unsignedSmallInteger('umpan_id');
                } else {
                    $table->unsignedInteger('umpan_id');
                }
            } else {
                $table->unsignedBigInteger('umpan_id'); // Default jika tidak bisa dideteksi
            }

            $table->timestamps();

            // Tambahkan unique constraint
            $table->unique(['spot_id', 'umpan_id']);
        });

        // Tambahkan foreign key constraints
        Schema::table('spot_umpan', function (Blueprint $table) {
            $table->foreign('spot_id')->references('id')->on('spots')->onDelete('cascade');
            $table->foreign('umpan_id')->references('id')->on('umpans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_umpan');
    }
};
