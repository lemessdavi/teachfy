<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users',
            'card_id' => 'required|exists:cards',
            'option_id' => 'exists:options|nullable',
            'difficulty' => 'nullable',
            'grade' => 'decimal:2|nullable',
            'feedback' => 'nullable'
        ];
    }
}
