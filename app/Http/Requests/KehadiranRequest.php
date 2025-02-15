<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KehadiranRequest extends FormRequest
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
            'tanggal' => 'required|date_format:Y-m-d',
            'kelas_id' => 'required|exists:classes,id',
            'kehadiran' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date_format' => 'Format tanggal harus YYYY-MM-DD',
            'kelas_id.required' => 'Kelas tidak boleh kosong',
            'kelas_id.exists' => 'Kelas tidak ditemukan',
            'kehadiran.required' => 'Kehadiran tidak boleh kosong',
            'kehadiran.array' => 'Kehadiran harus berupa array',
            'kehadiran.min' => 'Kehadiran harus memiliki minimal 1 data',
        ];
    }
}
