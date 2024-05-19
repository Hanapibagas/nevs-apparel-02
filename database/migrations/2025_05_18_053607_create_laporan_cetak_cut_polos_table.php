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
        Schema::create('laporan_cetak_cut_polos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('press_kain_id')->nullable()->constrained('data_manual_cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kain_id')->nullable()->constrained('bahan_kains')->onUpdate('cascade')->onDelete('cascade');
            $table->string('daerah')->nullable();
            $table->string('total_kain')->nullable();
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
        Schema::dropIfExists('laporan_cetak_cut_polos');
    }
};
