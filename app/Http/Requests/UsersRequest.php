<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        $userId = $this->id ? $this->id : ''; // Ambil ID siswa jika ada  
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'nip' => 'required|numeric|digits:18|unique:users,nip,' . $userId,
            'nohp' => 'required|numeric|digits_between:10,13|unique:users,nohp,' . $userId,
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'role' => [
                'required',
                'string',
                'in:guru,kepala_sekolah,staff_administrasi,admin',
                function ($attribute, $value, $fail) {
                    if ($value === 'kepala_sekolah') {
                        $existingKepalaSekolah = \App\Models\User::where('role', 'kepala_sekolah')
                            ->where('id', '!=', $this->id)
                            ->exists();
                        if ($existingKepalaSekolah) {
                            $fail('Kepala Sekolah sudah ada, tidak bisa menambahkan lagi.');
                        }
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nip.digits' => 'NIP harus terdiri dari 18 digit angka',
            'nohp.required' => 'No HP harus diisi',
            'nohp.digits' => 'No HP harus minimal dari 10 digit angka',
            'role.required' => 'Role harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus terdiri dari 8 karakter atau lebih',
            'nohp.numeric' => 'No HP harus berupa angka',
            'nip.numeric' => 'NIP harus berupa angka',
            'nohp.unique' => 'No HP sudah terdaftar',
        ];
    }
}
