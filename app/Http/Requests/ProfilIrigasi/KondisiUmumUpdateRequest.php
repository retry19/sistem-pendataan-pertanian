<?php

namespace App\Http\Requests\ProfilIrigasi;

use Illuminate\Foundation\Http\FormRequest;

class KondisiUmumUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_daerah_irigasi' => 'required|string|max:32',
            'nama_kantor_pengelola' => 'required|string|max:32',
            'luas_areal_baku' => 'required|numeric|min:0',
            'luas_potensial' => 'required|numeric|min:0',
            'luas_fungsional' => 'required|numeric|min:0',
            'kewenangan_operasional' => 'required|string|max:32',
            'kewenangan_pemeliharaan' => 'required|string|max:32',
            'kewenangan_rehabilitasi' => 'required|string|max:32',
            'nama_sumber_air' => 'required|array|min:1',
            'nama_sumber_air.*' => 'required|string|max:32',
            'nama_sungai' => 'required|string|max:32',
            'lokasi_bendung_desa' => 'required|string|max:32',
            'lokasi_bendung_kecamatan' => 'required|string|max:32',
            'posisi_di_daerah_irigasi' => 'nullable|min:1',
            'nama_hulu_daerah_irigasi' => 'nullable|array|min:1',
            'nama_hulu_daerah_irigasi.*' => 'nullable|string|max:32',
            'nama_hilir_daerah_irigasi' => 'nullable|array|min:1',
            'nama_hilir_daerah_irigasi.*' => 'nullable|string|max:32',
            'lokasi_pelayanan_daerah_irigasi' => 'nullable|array|min:1',
            'lokasi_pelayanan_daerah_irigasi.*.desa' => 'nullable|string|max:32',
            'lokasi_pelayanan_daerah_irigasi.*.kecamatan' => 'nullable|string|max:32',
            'lokasi_pelayanan_daerah_irigasi.*.luas' => 'nullable|numeric|min:0',
            'posisi_di_saluran_sekunder' => 'nullable|min:1',
            'nama_hulu_saluran_sekunder' => 'nullable|array|min:1',
            'nama_hulu_saluran_sekunder.*' => 'nullable|string|max:32',
            'nama_middle_saluran_sekunder' => 'nullable|array|min:1',
            'nama_middle_saluran_sekunder.*' => 'nullable|string|max:32',
            'nama_hilir_saluran_sekunder' => 'nullable|array|min:1',
            'nama_hilir_saluran_sekunder.*' => 'nullable|string|max:32',
            'lokasi_pelayanan_saluran_sekunder' => 'nullable|array|min:1',
            'lokasi_pelayanan_saluran_sekunder.*.desa' => 'nullable|string|max:32',
            'lokasi_pelayanan_saluran_sekunder.*.kecamatan' => 'nullable|string|max:32',
            'lokasi_pelayanan_saluran_sekunder.*.luas' => 'nullable|numeric|min:0',
            'jml_p3a' => 'nullable|numeric|min:0',
            'jml_gp3a' => 'nullable|numeric|min:0',
            'jml_ip3a' => 'nullable|numeric|min:0',
            'jml_poktan' => 'nullable|numeric|min:0',
            'jml_gapoktan' => 'nullable|numeric|min:0',
            'jml_petani_laki_laki' => 'nullable|numeric|min:0',
            'jml_petani_perempuan' => 'nullable|numeric|min:0',
            'tgl_survei' => 'required|date',
        ];
    }
}
