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
        Schema::create('data_sortirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('manual_cut_id')->nullable()->constrained('cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('deadline')->nullable();
            $table->string('no_error')->nullable();
            $table->string('panjang_kertas')->nullable();
            $table->string('berat')->nullable();
            $table->string('bahan')->nullable();
            $table->string('foto')->nullable();
            $table->string('selesai')->nullable();
            $table->string('tanda_telah_mengerjakan')->default('0');
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
        Schema::dropIfExists('data_sortirs');
    }
};
