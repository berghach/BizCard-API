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
                'contact' => ['nullable','array'],
                'contact.phone_number' => ['nullable'],
                'contact.e_mail' => ['nullable','email'], 
                'contact.links' => ['nullable','array'],
                'contact.links.*.name' => ['required_with:contact.links'],
                'contact.links.*.url' => ['required_with:contact.links','url'],
            ];
        }else{
            return [
                'company'=>['sometime','required'],
                'card_owner'=>['sometime','required'],
                'occupation'=>['sometime','required'],
                'adresse'=>['sometime','required'],
                'bio'=>['sometime','required'],
                'contact' => ['nullable','array'],
                'contact.phone_number' => ['nullable'],
                'contact.e_mail' => ['nullable','email'], 
                'contact.links' => ['nullable','array'],
                'contact.links.*.name' => ['required_with:contact.links'],
                'contact.links.*.url' => ['required_with:contact.links','url'],
            ];
        }
    }
}
