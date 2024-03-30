<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
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
        return [
            'company'=>['required'],
            'card_owner'=>['required'],
            'occupation'=>['required'],
            'adresse'=>['required'],
            'bio'=>['required'],
            'phone_number' => ['required'],
            'e_mail' => ['required','email'], 
            'links' => ['nullable','array'],
            'links.*.name' => ['required_with:links'],
            'links.*.url' => ['required_with:links','url'],
        ];
    }
}
