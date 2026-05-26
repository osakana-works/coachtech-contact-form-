<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|required|integer|in:1,2,3',
            'email' => 'sometimes|required|string|email|max:255',
            'tel' => 'sometimes|required|string|regex:/^[0-9]{10,11}$/',
            'address' => 'sometimes|required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'detail' => 'sometimes|required|string|max:120',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => '姓を入力してください',
            'last_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別の値が不正です',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.regex' => '電話番号はハイフンなしの10〜11桁で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists' => '選択されたカテゴリーが存在しません',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
            'tag_ids.*.exists' => '選択されたタグが存在しません',
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
}
