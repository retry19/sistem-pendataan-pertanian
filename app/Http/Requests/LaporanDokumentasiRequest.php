<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanDokumentasiRequest extends FormRequest
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
            'tahun' => "required|digits:4|integer|min:{$lastYear}|max:{$year}",
            'kuartal_id' => 'required',
        ];
    }
}
