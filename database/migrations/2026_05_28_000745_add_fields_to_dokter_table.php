<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->enum('jenkel', ['Pria', 'Wanita'])->nullable()->after('nama_dokter');
            $table->text('alamat')->nullable()->after('jenkel');
            $table->string('telp', 30)->nullable()->after('alamat');
            $table->string('spesialis', 30)->nullable()->after('telp');
            $table->foreignId('id_user')->nullable()->constrained('user')->onDelete('set null')->after('spesialis');
        });
    }

    public function down()
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn(['jenkel', 'alamat', 'telp', 'spesialis', 'id_user']);
        });
    }
};
