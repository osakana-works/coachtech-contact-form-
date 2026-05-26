<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexContactRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => 'nullable|string|max:255',
            'gender' => 'nullable|integer|in:0,1,2,3',
            'category_id' => 'nullable|integer|exists:categories,id',
            'date' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            'gender.in' => '性別の値が不正です',
            'category_id.exists' => '選択されたカテゴリーが存在しません',
        ];
    }
}
