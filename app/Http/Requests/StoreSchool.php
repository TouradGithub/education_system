<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchool extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:info_schools',
            'password' => 'required',
            'type' => 'required',
            'grade_id' => 'required',
            'description' => 'required',
            'academy_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('validation.required'),
            'type.required' => trans('validation.required'),
            'description.required' => trans('validation.required'),
            'academy_id.required' => trans('validation.required'),
            'grade_id.required' => trans('validation.required'),
            'name.unique' => trans('validation.unique'),
            'email.unique' => trans('validation.unique'),
        ];
    }
}
