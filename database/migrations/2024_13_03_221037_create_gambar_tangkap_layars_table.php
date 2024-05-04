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
        Schema::create('gambar_tangkap_layars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_datalayouts_id')->nullable()->constrained('barang_masuk_datalayouts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_tangkap_layar_player')->nullable();
            $table->string('file_tangkap_layar_pelatih')->nullable();
            $table->string('file_tangkap_layar_kiper')->nullable();
            $table->string('file_tangkap_layar_1')->nullable();
            $table->string('file_tangkap_layar_celana_pelayer')->nullable();
            $table->string('file_tangkap_layar_celana_pelatih')->nullable();
            $table->string('file_tangkap_layar_celana_kiper')->nullable();
            $table->string('file_tangkap_layar_celana_1')->nullable();
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
        Schema::dropIfExists('gambar_tangkap_layars');
    }
};
