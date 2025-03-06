<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('umpans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori'); // Natural Bait, Artificial Bait dll
            $table->string('jenis_ikan');
            $table->string('jenis_air'); // Air Tawar, Air Asin, Air Payau
            $table->string('waktu_terbaik'); // Pagi, Siang, Sore, Malam
            $table->integer('efektivitas')->default(0); // 0-100%
            $table->text('deskripsi')->nullable();
            $table->string('badge')->nullable(); // Recommended, Popular, Best Choice
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('umpans');
    }
};
