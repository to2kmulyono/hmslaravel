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
        Schema::table('obats', function (Blueprint $table) {
            $table->string('kode_obat')->nullable()->after('id');
            $table->string('satuan')->nullable()->after('nama_obat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn(['kode_obat', 'satuan']);
        });
    }
};
