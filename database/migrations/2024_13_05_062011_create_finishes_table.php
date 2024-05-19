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
        Schema::create('finishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jahit_baju_id')->nullable()->constrained('jahits')->onUpdate('cascade')->onDelete('cascade');
            // LK
            $table->foreignId('lk_player_id')->nullable()->constrained('lk_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_pelatih_id')->nullable()->constrained('lk_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_kiper_id')->nullable()->constrained('lk_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_1_id')->nullable()->constrained('lk_baju1s')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_player_id')->nullable()->constrained('lk_celana_players')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_pelatih_id')->nullable()->constrained('lk_celana_pelatihs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_kiper_id')->nullable()->constrained('lk_celana_kipers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lk_celana_1_id')->nullable()->constrained('lk_celana1s')->onUpdate('cascade')->onDelete('cascade');
            // AKHIR LK
            $table->string('deadline')->nullable();
            $table->string('selesai')->nullable();
            // AWAL
            $table->string('foto')->nullable();
            $table->string('foto_pelatih')->nullable();
            $table->string('foto_kiper')->nullable();
            $table->string('foto_1')->nullable();
            $table->string('foto_celana_pelayer')->nullable();
            $table->string('foto_celana_pelatih')->nullable();
            $table->string('foto_celana_kiper')->nullable();
            $table->string('foto_celana_1')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('keterangan2')->nullable();
            $table->string('keterangan3')->nullable();
            $table->string('keterangan4')->nullable();
            $table->string('keterangan5')->nullable();
            $table->string('keterangan6')->nullable();
            $table->string('keterangan7')->nullable();
            $table->string('keterangan8')->nullable();
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
        Schema::dropIfExists('finishes');
    }
};
