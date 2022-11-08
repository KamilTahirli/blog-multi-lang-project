<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if(isset($this->user->id))
        {
            $userId = $this->user->id;

        }else{
            $userId = NULL;
        }

        return [
           'name' => 'required|min:3|max:20',
           'email' => 'required|email|unique:users,email,'.$userId,
           'photo' => 'nullable|mimes:jpeg,png,jpg'

        ];
    }
}
