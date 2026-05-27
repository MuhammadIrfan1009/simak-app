<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'semester' => 'required|integer|min:1|max:8',
            'tahun_akademik' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nilai_tugas.required' => 'Nilai tugas harus diisi',
            'nilai_uts.required' => 'Nilai UTS harus diisi',
            'nilai_uas.required' => 'Nilai UAS harus diisi',
            '*.numeric' => 'Nilai harus berupa angka',
            '*.max' => 'Nilai maksimal adalah 100',
        ];
    }
}
