<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang');
            $table->integer('kapasitas')->default(0);
            $table->string('status')->default('Tersedia'); // Tersedia, Penuh, Perbaikan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangs');
    }
};
