<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // no auth system required by the brief; open this up
    }

    public function rules(): array
    {
        return [
            'date'          => ['required', 'date'],
            'cost'          => ['required', 'numeric', 'min:0'],
            'description'   => ['required', 'string', 'max:255'],
            'expense_type'  => ['required', 'in:travel,food,other'],
        ];
    }
}