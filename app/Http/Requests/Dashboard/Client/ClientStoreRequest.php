<?php
namespace App\Http\Requests\Dashboard\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientStoreRequest extends FormRequest
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
        // Phone length logic based on country code
        $countryCode    = $this->input('country_code');
        $phoneLengths   = phoneNumberLengths();
        $expectedLength = $phoneLengths[$countryCode] ?? null;

        return [

            // Basic fields
            'name'         => 'required|string|max:100',
            'status'       => 'nullable|in:new,contacted,interested,closed',
            'source_id'    => 'nullable|exists:sources,id',
            'assigned_to'  => 'nullable|exists:admins,id',
            // 'notes'        => 'nullable|string|max:5000',
            'is_archived'  => 'boolean',
            'created_by'   => 'nullable|exists:admins,id',

            // Unique Email
            'email'        => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('clients', 'email'),
            ],

            // Country code
            'country_code' => [
                'nullable',
                'string',
                Rule::in(array_keys($phoneLengths)),
            ],

            // Phone
            'phone'        => [
                'required',
                'string',
                Rule::unique('clients', 'phone'),
                function ($attribute, $value, $fail) use ($expectedLength) {
                    if ($expectedLength && strlen(preg_replace('/\D/', '', $value)) != $expectedLength) {
                        $fail("رقم الهاتف يجب أن يحتوي على {$expectedLength} أرقام بناءً على كود الدولة.");
                    }
                },
            ],

            // Owner information
            'national_id'      => [
                'nullable',
                'digits_between:8,20',
                Rule::unique('clients', 'national_id'),
            ],

            'birth_date'       => [
                'nullable',
                'date',
                'before:today',
            ],

            'national_address' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
