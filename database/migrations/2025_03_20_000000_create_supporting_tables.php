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
    public function up()
    {
        // Create riwayat_kunjungan table
        Schema::create('riwayat_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_id')->nullable()->constrained('antrian')->onDelete('set null');
            $table->foreignId('pasien_id')->nullable()->constrained('datapasien')->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->onDelete('set null');
            $table->foreignId('poliklinik_id')->nullable()->constrained('poliklinik')->onDelete('set null');
            $table->string('kode_kunjungan')->unique();
            $table->string('no_antrian');
            $table->string('nama_pasien');
            $table->string('nama_dokter');
            $table->string('poliklinik');
            $table->date('tanggal_kunjungan');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->integer('durasi_pelayanan')->nullable(); // in minutes
            $table->string('status')->default('dilayani');
            $table->string('penjamin')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Add unique constraint to ratings table if it exists
        if (Schema::hasTable('ratings')) {
            Schema::table('ratings', function (Blueprint $table) {
                // Ensure a user can only rate a doctor once
                $table->unique(['dokter_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique(['dokter_id', 'user_id']);
        });
        Schema::dropIfExists('riwayat_kunjungan');
    }
};
