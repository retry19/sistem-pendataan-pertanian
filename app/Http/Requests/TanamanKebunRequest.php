<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TanamanKebunRequest extends FormRequest
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
            'tanaman_id' => 'required|numeric',
            'tahun' => "nullable|digits:4|integer|min:{$lastYear}|max:{$year}",
            'tanaman_awal' => 'required|numeric',
            'dibongkar' => 'nullable|numeric',
            'ditambah' => 'nullable|numeric',
            'blm_menghasilkan' => 'nullable|numeric',
            'sdg_menghasilkan' => 'nullable|numeric',
            'produksi' => 'nullable|numeric',
        ];
    }
}
