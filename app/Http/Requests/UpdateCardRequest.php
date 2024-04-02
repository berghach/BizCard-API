<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
        $method = $this->method();

        if($method == 'PUT'){
            return [
                'company'=>['required'],
                'card_owner'=>['required'],
                'occupation'=>['required'],
                'adresse'=>['required'],
                'bio'=>['required'],
                'phone_number' => ['required'],
                'e_mail' => ['required','email'],
            ];
        }else{
            return [
                'company'=>['sometimes','required'],
                'card_owner'=>['sometimes','required'],
                'occupation'=>['sometimes','required'],
                'adresse'=>['sometimes','required'],
                'bio'=>['sometimes','required'],
                'phone_number' => ['sometimes','required'],
                'e_mail' => ['sometimes','required','email'],
            ];
        }
    }
}
