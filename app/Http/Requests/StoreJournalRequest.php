<?php

namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class StoreJournalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
 
    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'mood'    => ['nullable', 'in:great,good,neutral,bad,terrible'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'content.min' => 'Isi jurnal minimal 10 karakter.',
        ];
    }
}