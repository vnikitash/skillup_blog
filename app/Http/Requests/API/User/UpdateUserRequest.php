<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'     => ['sometimes', 'required', 'string', 'email'],
            'password'  => ['sometimes', 'required', 'string', 'min:6'],
            'name'      => ['sometimes', 'required', 'string', 'min:2']
        ];
    }
}
