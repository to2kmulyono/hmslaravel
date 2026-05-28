<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ruangs', function (Blueprint $table) {
            // Drop existing foreign key and column if exists
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');

            // Re-add column with correct foreign key reference to 'user' table
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->foreign('petugas_id')
                  ->references('id')
                  ->on('user')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruangs', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');
            $table->unsignedBigInteger('petugas_id');
            $table->foreign('petugas_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
