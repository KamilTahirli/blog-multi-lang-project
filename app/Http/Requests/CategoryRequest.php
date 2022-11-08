<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if(isset($this->category->id))
        {
            $categoryId = $this->category->id;

        }else{
            $categoryId = NULL;
        }

        return [
           'name' => 'required|min:3|max:25|unique:categories,name,'.$categoryId,
        ];
    }
}
