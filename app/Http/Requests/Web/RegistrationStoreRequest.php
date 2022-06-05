<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            
            'name' => 'bail|required|min:3',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|confirmed|min:6',
            'image' => 'bail|required|mimes:jpg,bmp,png,jpeg|max:1024',
        ];
    }

    /**
     * Modify validated data
     *
     * @return array
     */
    public function validated(): array
    {
        $data = parent::validated();
        $data['password'] = bcrypt($data['password']);
        
        return $data;
    }
}
