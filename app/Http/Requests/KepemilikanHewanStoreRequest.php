<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KepemilikanHewanStoreRequest extends FormRequest
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
            'blok' => 'required|string|max:30',
            'pemilik' => 'required|string|max:32',
            'jumlah' => 'required|numeric'
        ];
    }
}
