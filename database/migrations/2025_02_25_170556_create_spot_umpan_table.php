<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotUmpanTable extends Migration
{
    public function up()
    {
        Schema::create('spot_umpan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spot_id')->constrained('spots');
            $table->foreignId('umpan_id')->constrained('umpans');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_umpan');
    }
}
