<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilIrigasi\KondisiUmumUpdateRequest;
use App\ProfilIrigasi;
use Illuminate\Http\Request;

class ProfilIrigasiController extends Controller
{
    public function index()
    {
        return view('profil-irigasi.index');
    }

    public function kondisiUmum(Request $request)
    {
        $year = $request->year ?? now()->format('Y');

        $profilIrigasi = ProfilIrigasi::where('tahun', $year)->first();
        if (!$profilIrigasi) {

        }
        // dd($profilIrigasi);

        return view('profil-irigasi.kondisi-umum');
    }

    public function kondisiUmumUpdate(KondisiUmumUpdateRequest $request)
    {
        return response()->json($request->validated());
    }

    private function generateRow()
    {
        $kondisiUmum = [
            'nama_daerah_irigasi' => '',
            'nama_kantor_pengelola' => '',
            'luas_areal_baku' => 0,
            'luas_potensial' => 0,
            'luas_fungsional' => 0,
            'kewenangan_operasional' => '',
            'kewenangan_pemeliharaan' => '',
            'kewenangan_rehabilitasi' => '',
            'nama_sumber_air' => [],
            'nama_sungai' => '',
            'lokasi_bendung_desa' => '',
            'lokasi_bendung_kecamatan' => '',
            'posisi_di_daerah_irigasi' => [],
            'nama_hulu_daerah_irigasi' => [],
            'nama_hilir_daerah_irigasi' => [],
            'lokasi_pelayanan_daerah_irigasi' => [],
            'posisi_di_saluran_sekunder' => [],
            'nama_hulu_saluran_sekunder' => [],
            'nama_middle_saluran_sekunder' => [],
            'nama_hilir_saluran_sekunder' => [],
            'lokasi_pelayanan_saluran_sekunder' => [],
            'jml_p3a' => 0,
            'jml_gp3a' => 0,
            'jml_ip3a' => 0,
            'jml_poktan' => 0,
            'jml_gapoktan' => 0,
            'jml_petani_laki_laki' => 0,
            'jml_petani_perempuan' => 0,
            'tgl_survei' => '',
        ];

        $sumberAir = [];
        $ketersediaanAir = [];
        $profilSosial = [];
        $profilTeknik = [];
        $profilKelembagaan = [];
        $kondisiUsahatani = [];
        $potensiSumberdayaLokal = [];

        ProfilIrigasi::create([
            'kondisi_umum' => json_encode($kondisiUmum),
            'sumber_air' => json_encode($sumberAir),
            'ketersediaan_air' => json_encode($ketersediaanAir),
            'profil_sosial' => json_encode($profilSosial),
            'profil_teknik' => json_encode($profilTeknik),
            'profil_kelembagaan' => json_encode($profilKelembagaan),
            'kondisi_usahatani' => 
        ]);
    }
}
