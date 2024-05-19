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
        Schema::create('laporan_kain_sortirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layout_id')->nullable()->constrained('data_sortirs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kertas_id')->nullable()->constrained('bahan_cetaks')->onUpdate('cascade')->onDelete('cascade');
            $table->string('daerah')->nullable();
            $table->string('total_kertas')->nullable();
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
        Schema::dropIfExists('laporan_kain_sortirs');
    }
};
