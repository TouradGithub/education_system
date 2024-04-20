<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentsRequest extends FormRequest
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
        $existFatherNotPresent = !$this->has('exist_father');

        $existFatherPresent = $this->has('exist_father');
        // dd($existFatherPresent );
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'gender'     =>'required',
            'mobile'     => 'regex:/^([0-9\s\-\+\(\)]*)$/',
            'image'      => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
            'blood_group'=> 'required',
            'mobile'     => 'required',
            'mobile'     => 'required',
            'section_id'       => 'required',
            'current_address'  => 'required',
            'permanent_address'=> 'required',
            // 'father_guardian_id'=> ,

            // 'exist_father' =>   $existFatherNotPresent ? 'nullable':'required' ,
            'father_gradian_id'=> $existFatherPresent ?    'required' : 'nullable',            'father_first_name' => $existFatherNotPresent ? 'required' : 'nullable',
            'father_dob'        => $existFatherNotPresent ? 'required' : 'nullable',
            'father_last_name'  => $existFatherNotPresent ? 'required' : 'nullable',
            'father_mobile'     => $existFatherNotPresent ? 'required' : 'nullable',
            'father_occupation' => $existFatherNotPresent ? 'required' : 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'regex'    => 'The :attribute must be a valid phone number.',
            'mimes'    => 'The :attribute must be a file of type: :values.',
            'image'    => 'The :attribute must be an image.',
            'max'      => 'The :attribute may not be greater than :max kilobytes.',
        ];
    }
}
