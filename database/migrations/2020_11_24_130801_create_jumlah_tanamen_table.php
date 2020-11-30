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
            $table->decimal('tanaman_awal', 6, 3);
            $table->decimal('dibongkar', 6, 3)->nullable();
            $table->decimal('ditambah', 6, 3);
            $table->decimal('blm_menghasilkan', 6, 3)->nullable();
            $table->decimal('sdg_menghasilkan', 6, 3);
            $table->decimal('produksi', 7, 3);
            $table->decimal('luas_rusak', 6, 3)->nullable();
            $table->decimal('produktifitas', 6, 3)->nullable();
            $table->year('tahun');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('kuartal_id')->index();
            
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->foreign('kuartal_id')
                ->references('id')->on('quarters')
                ->onDelete('cascade');

            $table->foreign('tanaman_id')
                ->references('id')->on('tanaman')
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
        Schema::dropIfExists('jumlah_tanaman');
    }
}
