<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id(); // ID Spot
            $table->string('nama'); // Nama lokasi
            $table->text('deskripsi')->nullable(); // Deskripsi lokasi
            $table->decimal('latitude', 10, 8); // Koordinat lintang
            $table->decimal('longitude', 11, 8); // Koordinat bujur
            $table->string('foto')->nullable(); // URL foto spot
            $table->text('rekomendasi_umpan')->nullable(); // Rekomendasi umpan
            $table->string('rekomendasi_cuaca')->nullable(); // Rekomendasi cuaca
            $table->timestamps(); // Waktu dibuat/diperbarui
        });

        Schema::create('spot_umpan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spot_id')->constrained()->onDelete('cascade');
            $table->foreignId('umpan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spots');
    }

};
