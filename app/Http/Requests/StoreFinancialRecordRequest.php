<?php

namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class StoreFinancialRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
 
    public function rules(): array
    {
        return [
            'type'        => ['required', 'in:income,expense'],
            'category'    => ['required', 'in:personal,business'],
            'amount'      => ['required', 'numeric', 'min:1', 'max:999999999999'],
            'description' => ['required', 'string', 'max:255'],
            'recorded_at' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'amount.min'         => 'Jumlah transaksi minimal Rp 1.',
            'recorded_at.before_or_equal' => 'Tanggal transaksi tidak boleh di masa depan.',
        ];
    }
}
