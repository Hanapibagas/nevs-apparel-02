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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_costumer_services_id')->nullable()->constrained('barang_masuk_costumer_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_layout_id')->nullable()->constrained('barang_masuk_datalayouts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_mesin_atexco_id')->nullable()->constrained('data_presses')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('barang_masuk_mesin_mimaki_id')->nullable()->constrained('mesin_mimakis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_presskain_id')->nullable()->constrained('data_press_kains')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('cut_id')->nullable()->constrained('cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_lasercut_id')->nullable()->constrained('data_laser_cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_manualcut_id')->nullable()->constrained('data_manual_cuts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('barang_masuk_sortir_id')->nullable()->constrained('data_sortirs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jahit_id')->nullable()->constrained('jahits')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('finis_id')->nullable()->constrained('finishes')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('barang_masuk_jahit_baju_id')->nullable()->constrained('data_jahit_bajus')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('barang_masuk_jahit_celana_id')->nullable()->constrained('data_jahit_celanas')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('barang_masuk_pressTagSize_id')->nullable()->constrained('data_press_tag_sizes')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('barang_masuk_packing_id')->nullable()->constrained('data_packings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->default('Layout');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('laporans');
    }
};
