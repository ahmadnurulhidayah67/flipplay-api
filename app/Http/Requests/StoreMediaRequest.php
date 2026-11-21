<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $patch = $this->isMethod('PATCH');
        $req   = $patch ? 'sometimes' : 'required';

        return [
            // judul wajib diisi dan tidak boleh duplikat (saat PATCH, abaikan media itu sendiri)
            'title'    => [$req, 'string', 'max:255',
                           Rule::unique('media', 'title')->ignore($this->route('media'))],
            'type'     => [$req, Rule::in(['Anime', 'Film', 'Series'])],
            'genre'    => ['nullable', 'string', 'max:100'],
            'score'    => ['nullable', 'numeric', 'min:0', 'max:10'],
            'episodes' => ['nullable', 'integer', 'min:0'],
            'vibe'     => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi',
            'title.unique'   => 'Judul media sudah ada di library',
            'type.required'  => 'Jenis media wajib diisi',
            'type.in'        => 'Jenis media harus Anime, Film, atau Series',
            'score.max'      => 'Skor maksimal 10',
            'score.min'      => 'Skor tidak boleh kurang dari 0',
        ];
    }
}
