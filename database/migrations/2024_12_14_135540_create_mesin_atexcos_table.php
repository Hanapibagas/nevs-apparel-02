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
        Schema::create('mesin_atexcos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_layout_id')->nullable()->constrained('barang_masuk_datalayouts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_player_id')->nullable()->constrained('lk_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_pelatih_id')->nullable()->constrained('lk_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_kiper_id')->nullable()->constrained('lk_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_1_id')->nullable()->constrained('lk_baju1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_player_id')->nullable()->constrained('lk_celana_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_pelatih_id')->nullable()->constrained('lk_celana_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_kiper_id')->nullable()->constrained('lk_celana_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_1_id')->nullable()->constrained('lk_celana1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('deadline')->nullable();
            $table->string('selesai')->nullable();
            $table->string('nama_mesin')->nullable();
            // LAPORAN
            $table->string('file_foto')->nullable();
            $table->string('file_foto_pelatih')->nullable();
            $table->string('file_foto_kiper')->nullable();
            $table->string('file_foto_1')->nullable();
            $table->string('file_foto_celana_player')->nullable();
            $table->string('file_foto_celana_pelatih')->nullable();
            $table->string('file_foto_celana_kiper')->nullable();
            $table->string('file_foto_celana_1')->nullable();
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
        Schema::dropIfExists('mesin_atexcos');
    }
};
