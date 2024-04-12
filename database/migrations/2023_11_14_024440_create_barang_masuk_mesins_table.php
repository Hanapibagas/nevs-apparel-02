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
        Schema::create('barang_masuk_mesins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_disainer_id')->constrained('barang_masuk_disainers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('nama_mesin_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('nama_penanggung_jawab_mesin_ACC')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');;
            $table->string('file');
            $table->string('status')->default('0');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuk_mesins');
    }
};
