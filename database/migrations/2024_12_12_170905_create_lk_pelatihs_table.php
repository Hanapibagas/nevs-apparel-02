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
        Schema::create('lk_pelatihs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kerah_baju_pelatih_id')->nullable()->constrained('kera_bajus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pola_lengan_pelatih_id')->nullable()->constrained('pola_lengans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jenis_sablon_baju_pelatih')->nullable();
            $table->string('status_pelatih')->nullable();
            $table->string('jenis_kain_baju_pelatih')->nullable();
            $table->string('total_baju_pelatih')->nullable();
            $table->string('ket_tambahan_baju_pelatih')->nullable();
            $table->longText('keterangan_baju_pelatih')->nullable();
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
        Schema::dropIfExists('lk_pelatihs');
    }
};
