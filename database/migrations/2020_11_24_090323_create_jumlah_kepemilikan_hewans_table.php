<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumlahKepemilikanHewansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumlah_kepemilikan_hewan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hewan_id')->index();
            $table->string('blok', 30);
            $table->string('pemilik', 32);
            $table->integer('jumlah');
            $table->year('tahun');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('kuartal_id')->index();

            $table->foreign('hewan_id')
                ->references('id')->on('hewan')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('kuartal_id')
                ->references('id')->on('quarters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jumlah_kepemilikan_hewans');
    }
}
