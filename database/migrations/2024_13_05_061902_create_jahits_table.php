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
        Schema::create('jahits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_order_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sortir_id')->nullable()->constrained('data_sortirs')->onUpdate('cascade')->onDelete('cascade');
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
            $table->string('leher')->nullable();
            $table->string('pola_badan')->nullable();
            $table->string('pola_celana')->nullable();
            $table->string('foto')->nullable();

            $table->string('leher_pelatih')->nullable();
            $table->string('pola_badan_pelatih')->nullable();
            $table->string('pola_celana_pelatih')->nullable();
            $table->string('foto_pelatih')->nullable();

            $table->string('leher_kiper')->nullable();
            $table->string('pola_badan_kiper')->nullable();
            $table->string('pola_celana_kiper')->nullable();
            $table->string('foto_kiper')->nullable();

            $table->string('leher_1')->nullable();
            $table->string('pola_badan_1')->nullable();
            $table->string('pola_celana_1')->nullable();
            $table->string('foto_1')->nullable();

            $table->string('leher_celana_pelayer')->nullable();
            $table->string('pola_badan_celana_pelayer')->nullable();
            $table->string('pola_celana_celana_pelayer')->nullable();
            $table->string('foto_celana_pelayer')->nullable();

            $table->string('leher_celana_pelatih')->nullable();
            $table->string('pola_badan_celana_pelatih')->nullable();
            $table->string('pola_celana_celana_pelatih')->nullable();
            $table->string('foto_celana_pelatih')->nullable();

            $table->string('leher_celana_kiper')->nullable();
            $table->string('pola_badan_celana_kiper')->nullable();
            $table->string('pola_celana_celana_kiper')->nullable();
            $table->string('foto_celana_kiper')->nullable();

            $table->string('leher_celana_1')->nullable();
            $table->string('pola_badan_celana_1')->nullable();
            $table->string('pola_celana_celana_1')->nullable();
            $table->string('foto_celana_1')->nullable();
            // AKHIR
            $table->string('tanda_telah_mengerjakan')->default('0');
            $table->string('serah_terima')->default('0');
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
        Schema::dropIfExists('jahits');
    }
};
