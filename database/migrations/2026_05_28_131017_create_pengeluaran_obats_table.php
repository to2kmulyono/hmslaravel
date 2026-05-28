<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pengeluaran_obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->unsignedBigInteger('obat_id');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Assuming rekam_medis table exists. If it's rekam_medis, we use that.
            $table->foreign('rekam_medis_id')->references('id')->on('rekam_medis')->onDelete('cascade');
            // Assuming the table is obats based on previous migration
            $table->foreign('obat_id')->references('id')->on('obats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluaran_obats');
    }
};
