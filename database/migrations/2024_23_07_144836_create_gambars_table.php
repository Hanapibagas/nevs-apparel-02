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
        Schema::create('gambars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_costumer_services_id')->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_baju_player')->nullable();
            $table->string('file_baju_pelatih')->nullable();
            $table->string('file_baju_kiper')->nullable();
            $table->string('file_baju_1')->nullable();
            $table->string('file_celana_player')->nullable();
            $table->string('file_celana_pelatih')->nullable();
            $table->string('file_celana_kiper')->nullable();
            $table->string('file_celana_1')->nullable();
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
        Schema::dropIfExists('gambars');
    }
};
