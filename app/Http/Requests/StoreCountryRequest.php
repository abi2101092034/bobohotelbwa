<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['required', 'string', 'max:255', 'unique:' . Country::class],
        ];
    }

    public function messages(): array
    {
        return [
            //
            'name.required' => 'Nama negara wajib di isi.',
            'name.string' => 'Nama negara harus berupa text.',
            'name.max' => 'Nama negara tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama negara sudah ada.',
        ];
    }
}