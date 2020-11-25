<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumlahTanamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumlah_tanaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tanaman_id')->index();
            $table->integer('tanaman_awal');
            $table->integer('dibongkar')->nullable();
            $table->integer('ditambah');
            $table->integer('blm_menghasilkan')->nullable();
            $table->integer('sdg_menghasilkan');
            $table->integer('produksi');
            $table->integer('luas_rusak')->nullable();
            $table->integer('produktifitas')->nullable();
            $table->year('tahun');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('kuartal_id')->index();
            
            // $table->foreign('user_id')
            //     ->references('id')->on('users')
            //     ->onDelete('set null');
            
            // $table->foreign('kuartal_id')
            //     ->references('id')->on('quarters')
            //     ->onDelete('cascade');

            // $table->foreign('tanaman_id')
            //     ->references('id')->on('tanaman')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jumlah_tanaman');
    }
}
