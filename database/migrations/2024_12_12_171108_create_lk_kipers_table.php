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
        Schema::create('lk_kipers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kerah_baju_kiper_id')->nullable()->constrained('kera_bajus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pola_lengan_kiper_id')->nullable()->constrained('pola_lengans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jenis_sablon_baju_kiper')->nullable();
            $table->string('status_kiper')->nullable();
            $table->string('jenis_kain_baju_kiper')->nullable();
            $table->string('total_baju_kiper')->nullable();
            $table->string('ket_tambahan_baju_kiper')->nullable();
            $table->longText('keterangan_baju_kiper')->nullable();
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
        Schema::dropIfExists('lk_kipers');
    }
};
