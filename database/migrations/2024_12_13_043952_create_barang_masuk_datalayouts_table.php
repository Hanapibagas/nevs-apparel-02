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
        Schema::create('barang_masuk_datalayouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_layout_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kertas_id')->nullable()->constrained('bahan_cetaks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_player_id')->nullable()->constrained('lk_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_pelatih_id')->nullable()->constrained('lk_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_kiper_id')->nullable()->constrained('lk_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_1_id')->nullable()->constrained('lk_baju1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_player_id')->nullable()->constrained('lk_celana_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_pelatih_id')->nullable()->constrained('lk_celana_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_kiper_id')->nullable()->constrained('lk_celana_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_1_id')->nullable()->constrained('lk_celana1s')->onUpdate('cascade')->onDelete('cascade');
            $table->string('deadline')->nullable();
            $table->string('selesai')->nullable();
            // AWAL
            $table->string('panjang_kertas_palayer')->nullable();
            $table->string('poly_player')->nullable();

            $table->string('panjang_kertas_pelatih')->nullable();
            $table->string('poly_pelatih')->nullable();

            $table->string('panjang_kertas_kiper')->nullable();
            $table->string('poly_kiper')->nullable();

            $table->string('panjang_kertas_1')->nullable();
            $table->string('poly_1')->nullable();

            $table->string('panjang_kertas_celana_pelayer')->nullable();
            $table->string('poly_celana_pelayer')->nullable();

            $table->string('panjang_kertas_celana_pelatih')->nullable();
            $table->string('poly_celana_pelatih')->nullable();

            $table->string('panjang_kertas_celana_kiper')->nullable();
            $table->string('poly_celana_kiper')->nullable();

            $table->string('panjang_kertas_celana_1')->nullable();
            $table->string('poly_celana_1')->nullable();
            // AKHIR
            $table->string('file_corel_layout')->nullable();
            $table->string('file_corel_layout2')->nullable();
            $table->string('file_corel_layout3')->nullable();
            $table->string('file_corel_layout4')->nullable();
            $table->string('file_corel_layout5')->nullable();
            $table->string('file_corel_layout6')->nullable();
            $table->string('file_corel_layout7')->nullable();
            $table->string('file_corel_layout8')->nullable();
            $table->string('keterangan1')->nullable();
            $table->string('keterangan2')->nullable();
            $table->string('keterangan3')->nullable();
            $table->string('keterangan4')->nullable();
            $table->string('keterangan5')->nullable();
            $table->string('keterangan6')->nullable();
            $table->string('keterangan7')->nullable();
            $table->string('keterangan8')->nullable();
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
        Schema::dropIfExists('barang_masuk_datalayouts');
    }
};
