<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        $rulesArr = [
            'id'     =>  ['required'],
            'first_name'     =>  ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
            'last_name'     =>  ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
            'email'       =>  'required|email|unique:users,email',
            'image'  =>  ['nullable','image','mimes:jpeg,jpg,png,gif,svg'],
            'password' => ['required', 'min:8'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'in:create,update,view,delete'],
        ];
        if(request()->id != 0){
            $rulesArr['password'] = ['nullable', 'min:8'];
            $rulesArr['email'] =  'required|email|unique:users,email,' . request()->id;
        }
        return $rulesArr;
    }
}
