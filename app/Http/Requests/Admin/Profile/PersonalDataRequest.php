<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDataRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:50|regex:' . $this->pattern['name'],
            'email'    => 'required|max:255|unique:admin,email,' . $this->id() . '|regex:' . $this->pattern['email'],
            'phone'    => 'nullable|unique:admin,phone,' . $this->id() . '|regex:' . $this->pattern['number'] . '|numeric|digits_between:11,11',
            'bio'      => 'nullable|max:3000',
            'password' => 'nullable|min:6|max:255',
        ];
    }
}
