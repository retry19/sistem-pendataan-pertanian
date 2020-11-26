<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PopulasiHewanStoreRequest extends FormRequest
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
        $year = date('Y');
        $lastYear = date('Y') - 1;

        return [
            'hewan_id' => 'required|numeric',
            'tahun' => "nullable|digits:4|integer|min:{$lastYear}|max:{$year}",
            'populasi_awal_jantan' => 'required|numeric|min:0',
            'populasi_awal_betina' => 'required|numeric|min:0',
            'jumlah_lahir_jantan' => 'nullable|numeric|min:0',
            'jumlah_lahir_betina' => 'nullable|numeric|min:0',
            'jumlah_dipotong_jantan' => 'nullable|numeric|min:0',
            'jumlah_dipotong_betina' => 'nullable|numeric|min:0',
            'jumlah_mati_jantan' => 'nullable|numeric|min:0',
            'jumlah_mati_betina' => 'nullable|numeric|min:0',
            'jumlah_masuk_jantan' => 'nullable|numeric|min:0',
            'jumlah_masuk_betina' => 'nullable|numeric|min:0',
            'jumlah_keluar_jantan' => 'nullable|numeric|min:0',
            'jumlah_keluar_betina' => 'nullable|numeric|min:0',
        ];
    }
}
