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
        Schema::create('data_manual_cuts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('laser_cut_id')->nullable()->constrained('data_laser_cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kain_id')->nullable()->constrained('bahan_kains')->onUpdate('cascade')->onDelete('cascade');
            // LK
            $table->foreignId('lk_player_id')->nullable()->constrained('lk_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_pelatih_id')->nullable()->constrained('lk_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_kiper_id')->nullable()->constrained('lk_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_1_id')->nullable()->constrained('lk_baju1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_player_id')->nullable()->constrained('lk_celana_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_pelatih_id')->nullable()->constrained('lk_celana_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_kiper_id')->nullable()->constrained('lk_celana_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_1_id')->nullable()->constrained('lk_celana1s')->onUpdate('cascade')->onDelete('cascade');
            // AKHIR LAPORAN
            $table->string('deadline')->nullable();
            $table->string('selesai')->nullable();
            // LAPORAN
            $table->string('file_foto')->nullable();
            $table->string('file_foto_pelatih')->nullable();
            $table->string('file_foto_kiper')->nullable();
            $table->string('file_foto_1')->nullable();
            $table->string('file_foto_celana_player')->nullable();
            $table->string('file_foto_celana_pelatih')->nullable();
            $table->string('file_foto_celana_kiper')->nullable();
            $table->string('file_foto_celana_1')->nullable();
            $table->string('kain')->nullable();
            $table->string('kain_pelatih')->nullable();
            $table->string('kain_kiper')->nullable();
            $table->string('kain_1')->nullable();
            $table->string('kain_celana_player')->nullable();
            $table->string('kain_celana_pelatih')->nullable();
            $table->string('kain_celana_kiper')->nullable();
            $table->string('kain_celana_1')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('keterangan2')->nullable();
            $table->string('keterangan3')->nullable();
            $table->string('keterangan4')->nullable();
            $table->string('keterangan5')->nullable();
            $table->string('keterangan6')->nullable();
            $table->string('keterangan7')->nullable();
            $table->string('keterangan8')->nullable();
            // AKHIR LAPORAN
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
        Schema::dropIfExists('data_manual_cuts');
    }
};
