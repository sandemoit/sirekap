<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends FormRequest
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
        $classId = $this->id ? $this->id : ''; // Ambil ID kelas jika ada
        return [
            'class_name' => 'required|unique:classes,name,' . $classId . '|max:255',
            'teacher_id' => 'required|exists:users,id|unique:classes,teacher_id,' . $classId,
        ];
    }

    public function messages()
    {
        return [
            'class_name.required' => 'Nama kelas harus diisi.',
            'class_name.unique' => 'Nama kelas sudah digunakan.',
            'class_name.max' => 'Nama kelas tidak boleh lebih dari 255 karakter.',
            'class_name.regex' => 'Nama kelas hanya boleh mengandung huruf, angka, spasi, dan tanda hubung.',
            'teacher_id.required' => 'Guru harus diisi.',
            'teacher_id.unique' => 'Guru sudah digunakan di kelas lain.',
            'teacher_id.exists' => 'Guru yang dipilih tidak valid.',
        ];
    }
}
