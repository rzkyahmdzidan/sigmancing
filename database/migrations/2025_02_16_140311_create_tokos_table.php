<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('no_telp')->nullable();
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
}
