<?php

use App\Hewan;
use App\Quarter;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePopulasiHewansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('populasi_hewan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hewan_id');
            $table->string('populasi_awal');
            $table->string('lahir');
            $table->string('dipotong');
            $table->string('mati');
            $table->string('masuk');
            $table->string('keluar');
            $table->year('tahun');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('kuartal_id');

            $table->foreign('hewan_id')
                ->references('id')->on('hewan')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');

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
        Schema::dropIfExists('populasi_hewan');
    }
}
