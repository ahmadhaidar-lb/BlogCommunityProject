<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePosts extends FormRequest
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
            //$this->validate($request, ['post' => 'required']);
            'post'=>'required|min:5',
            'category'=>'required',
            'title'=>'required|min:5',
            'image'=> 'image'
           
        ];
    }
    public function messages()
    {
        return [
            'post' => 'Your post must contain 5 characters at least',
            // ..
        ];
    }
    
}
