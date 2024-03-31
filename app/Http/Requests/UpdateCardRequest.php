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
                'company'=>['sometime','required'],
                'card_owner'=>['sometime','required'],
                'occupation'=>['sometime','required'],
                'adresse'=>['sometime','required'],
                'bio'=>['sometime','required'],
                'phone_number' => ['sometime','required'],
                'e_mail' => ['sometime','required','email'],
            ];
        }
    }
}
