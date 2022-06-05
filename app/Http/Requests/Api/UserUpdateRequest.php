<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $id = User::uuid($this->route('uuid'))->id;

        return [
            'name' => 'bail|required|min:3',
            'email' => 'bail|required|email|unique:users,email,'.$id,
            'image' => 'bail|required|mimes:jpg,bmp,png,jpeg|max:1024',
        ];
    }
}
