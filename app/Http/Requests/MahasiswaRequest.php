<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->mahasiswa->id ?? null;

        return [
            'nim' => "required|string|unique:mahasiswas,nim,$id",
            'nama' => 'required|string|max:255',
            'email' => "required|email|unique:mahasiswas,email,$id",
            'jurusan' => 'required|in:Informatika,Sistem Informasi,Teknik Komputer',
            'angkatan' => 'required|string|max:4|regex:/^\d{4}$/',
            'alamat' => 'nullable|string|max:500',
            'no_telepon' => 'nullable|string|regex:/^\+?[\d\s\-\(\)]{10,}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'nim.unique' => 'NIM sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'jurusan.in' => 'Jurusan tidak valid',
            'angkatan.regex' => 'Angkatan harus 4 digit tahun',
            'no_telepon.regex' => 'Format nomor telepon tidak valid',
        ];
    }
}
