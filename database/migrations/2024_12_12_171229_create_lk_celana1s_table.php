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
        Schema::create('lk_celana1s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pola_celana_1_id')->nullable()->constrained('pola_lengans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kerah_celana_1_id')->nullable()->constrained('kera_bajus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status_celana_1')->nullable();
            $table->string('total_celana_1')->nullable();
            $table->string('jenis_sablon_celana_1')->nullable();
            $table->string('jenis_kain_celana_1')->nullable();
            $table->longText('ket_tambahan_celana_1')->nullable();
            $table->longText('keterangan_celana_1')->nullable();
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
        Schema::dropIfExists('lk_celana1s');
    }
};
