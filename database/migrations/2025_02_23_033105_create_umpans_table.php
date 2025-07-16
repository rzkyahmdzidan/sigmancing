<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmpansTable extends Migration
{
    public function up()
    {
        Schema::create('umpans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori');
            $table->string('jenis_ikan');
            $table->string('jenis_air');
            $table->string('waktu_terbaik');
            $table->text('deskripsi')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('umpans');
    }
}
