<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $studentId = $this->id ? $this->id : ''; // Ambil ID siswa jika ada  

        return [
            'name' => 'required|string|max:255',
            'nis' => 'required|string|numeric|unique:students,nis,' . $studentId,
            'nisn' => 'required|string|numeric|unique:students,nisn,' . $studentId,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'religion' => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama siswa harus diisi.',
            'nis.required' => 'NIS harus diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nisn.required' => 'NISN harus diisi.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'gender.required' => 'Jenis kelamin harus dipilih.',
            'religion.required' => 'Agama harus diisi.',
            'class_id.required' => 'Kelas harus dipilih.',
            'class_id.exists' => 'Kelas yang dipilih tidak valid.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'gender.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        ];
    }
}
