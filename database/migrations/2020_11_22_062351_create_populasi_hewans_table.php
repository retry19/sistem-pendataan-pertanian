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
            $table->string('populasi_akhir');
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

        $populasiAwal['jantan'] = 20;
        $populasiAwal['betina'] = 15;
        $lahir['jantan'] = 0;
        $lahir['betina'] = 0;
        $diPotong['jantan'] = 0;
        $diPotong['betina'] = 0;
        $mati['jantan'] = 0;
        $mati['betina'] = 0;
        $masuk['jantan'] = 0;
        $masuk['betina'] = 0;
        $keluar['jantan'] = 0;
        $keluar['betina'] = 0;
        $populasiAkhir['jantan'] = 0;
        $populasiAkhir['betina'] = 0;

        DB::table('populasi_hewan')->insert([
            'hewan_id' => Hewan::get()->first()->id,
            'populasi_awal' => json_encode($populasiAwal),
            'lahir' => json_encode($lahir),
            'dipotong' => json_encode($diPotong),
            'mati' => json_encode($mati),
            'masuk' => json_encode($masuk),
            'keluar' => json_encode($keluar),
            'populasi_akhir' => json_encode($populasiAkhir),
            'tahun' => now()->format('Y'),
            'user_id' => User::get()->first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
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
