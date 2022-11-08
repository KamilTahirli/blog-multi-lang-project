<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        if(isset($this->post->id))
        {
            $postId = $this->post->id;

        }else{
            $postId = NULL;
        }

        if($this->lang != 'null' && $this->post_id != 'null')
        {
          // Əgər mövcud post - a fərqli dil əlavə edilirsə bu validationlar yoxlanılacaq

            return [
                'title' => 'required|min:3|unique:post_translations,title,'.$postId,
                'content' => 'required|min:3',
             ];
        }else{
            return [
                'title' => 'required|min:3|unique:post_translations,title,'.$postId,
                'content' => 'required|min:3',
                'images' => 'required|mimes:jpg,png,jpeg',
                'category_id' => 'required'
             ];
        }

    }
}
