<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $postId = request()->id;
        $rulesArr = [
            'id'     =>  ['required'],
            'title'     =>  ['required', 'string', 'max:255'],
            'image'  =>  ['nullable','image','mimes:jpeg,jpg,png,gif,svg'],
            'description' => ['required', 'max:5000'],
        ];
        return $rulesArr;
    }
}
