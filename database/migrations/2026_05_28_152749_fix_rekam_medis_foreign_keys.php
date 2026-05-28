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
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Drop existing foreign keys that point to 'users'
            $table->dropForeign(['pasien_id']);
            $table->dropForeign(['dokter_id']);
            
            // Add new foreign keys pointing to 'user'
            $table->foreign('pasien_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Drop foreign keys pointing to 'user'
            $table->dropForeign(['pasien_id']);
            $table->dropForeign(['dokter_id']);
            
            // Revert back to 'users' (optional, but good practice)
            // Note: Since 'users' might not exist, this could fail on rollback.
            // Leaving it commented out is safer if 'users' table is entirely removed.
            // $table->foreign('pasien_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('dokter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
