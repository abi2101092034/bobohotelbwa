<?php

namespace App\Http\Requests;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:' . City::class],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kota wajib diisi.',
            'name.string' => 'Nama kota harus berupa teks.',
            'name.max' => 'Nama kota tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kota sudah ada !',
        ];
    }
}
