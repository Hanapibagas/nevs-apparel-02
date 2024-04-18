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
        Schema::create('data_press_kains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mesin_atexco_id')->nullable()->constrained('mesin_atexcos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mesin_mimaki_id')->nullable()->constrained('mesin_mimakis')->onUpdate('cascade')->onDelete('cascade');
            // LK
            $table->foreignId('lk_player_id')->nullable()->constrained('lk_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_pelatih_id')->nullable()->constrained('lk_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_kiper_id')->nullable()->constrained('lk_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_1_id')->nullable()->constrained('lk_baju1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_player_id')->nullable()->constrained('lk_celana_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_pelatih_id')->nullable()->constrained('lk_celana_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_kiper_id')->nullable()->constrained('lk_celana_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_1_id')->nullable()->constrained('lk_celana1s')->onUpdate('cascade')->onDelete('cascade');
            // AKHRIR LK
            $table->string('deadline')->nullable();
            $table->string('selesai')->nullable();
            // AWAL
            $table->string('kain')->nullable();
            $table->string('berat')->nullable();
            $table->string('gambar')->nullable();

            $table->string('kain_pelatih')->nullable();
            $table->string('berat_pelatih')->nullable();
            $table->string('gambar_pelatih')->nullable();

            $table->string('kain_kiper')->nullable();
            $table->string('berat_kiper')->nullable();
            $table->string('gambar_kiper')->nullable();

            $table->string('kain_1')->nullable();
            $table->string('berat_1')->nullable();
            $table->string('gambar_1')->nullable();

            $table->string('kain_celana_player')->nullable();
            $table->string('berat_celana_player')->nullable();
            $table->string('gambar_celana_player')->nullable();

            $table->string('kain_celana_pelatih')->nullable();
            $table->string('berat_celana_pelatih')->nullable();
            $table->string('gambar_celana_pelatih')->nullable();

            $table->string('kain_celana_kiper')->nullable();
            $table->string('berat_celana_kiper')->nullable();
            $table->string('gambar_celana_kiper')->nullable();

            $table->string('kain_celana_1')->nullable();
            $table->string('berat_celana_1')->nullable();
            $table->string('gambar_celana_1')->nullable();
            // AKHIR
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
        Schema::dropIfExists('data_press_kains');
    }
};
