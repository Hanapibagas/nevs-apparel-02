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
        Schema::create('barang_masuk_costumer_services', function (Blueprint $table) {
            $table->id();
            $table->string('no_order')->nullable();
            $table->string('kota_produksi')->nullable();
            $table->foreignId('barang_masuk_disainer_id')->constrained('barang_masuk_disainers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cs_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('disainer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jenis_mesin')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->string('jenis_mesin')->nullable();
            $table->string('no_nota')->nullable();

            $table->foreignId('layout_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jenis_produksi')->nullable();
            $table->string('pola')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('deadline')->nullable();
            $table->string('ket_hari')->nullable();

            $table->string('total_baju_player')->nullable();
            $table->string('total_baju_pelatih')->nullable();
            $table->string('total_baju_kiper')->nullable();
            $table->string('total_baju_1')->nullable();
            $table->string('total_celana_player')->nullable();
            $table->string('total_celana_pelatih')->nullable();
            $table->string('total_celana_kiper')->nullable();
            $table->string('total_celana_1')->nullable();

            $table->longText('file_corel_disainer')->nullable();
            $table->longText('keterangan_lengkap')->nullable();

            $table->string('aksi')->default('0');
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
        Schema::dropIfExists('barang_masuk_costumer_services');
    }
};
