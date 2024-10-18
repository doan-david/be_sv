<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => 'string|unique:students,code|max:50',
            'name' => 'max:25',
            'username' => 'max:25',
            'password' => 'string|min:6|max:25',
            'email' => 'email',
            'gender' => 'in:male,female',
            'birthday' => 'date',
            'phone' => 'min:9|max:20',
            'address' => 'string|max:200',
            'hobby' => 'max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'in:active,in active',
            'description' => 'string|max:225',

//            'code' => 'required|string|unique:students,code|max:50',
//            'name' => 'required|string|max:25',
//            'username' => 'string|max:25',
//            'password' => 'required|string|min:6|max:25',
//            'email' => 'required|email',
//            'gender' => 'required|in:male,female',
//            'birthday' => 'required|date',
//            'phone' => 'string|min:9|max:20',
//            'address' => 'required|string|max:200',
//            'hobby' => 'max:100',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'status' => 'required|in:active,inactive',
//            'description' => 'string|max:225',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
