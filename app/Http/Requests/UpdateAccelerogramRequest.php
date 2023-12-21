<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccelerogramRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'accuracy' => 'required|in:90,95,98,99',
            't, sec А' => 'required|numeric',
            'E (cm/s2)' => 'required|numeric',
            'N (cm/s2)' => 'required|numeric',
            'Z (cm/s2)' => 'required|numeric',
        ];
    }
}
