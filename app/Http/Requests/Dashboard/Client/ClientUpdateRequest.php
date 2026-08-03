<?php
namespace App\Http\Requests\Dashboard\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Get current client ID from route model binding (Client $client)
        $clientId = $this->client->id ?? null;

        // Phone length logic based on country code
        $countryCode    = $this->input('country_code');
        $phoneLengths   = phoneNumberLengths();
        $expectedLength = $phoneLengths[$countryCode] ?? null;

        return [
            // Basic fields
            'name'         => 'required|string|max:100',
            // 'phone_alt'       => 'nullable|string|max:30',
            'status'       => 'nullable|in:new,contacted,interested,closed',
            'source_id'    => 'nullable|exists:sources,id',
            'assigned_to'  => 'nullable|exists:admins,id',
            // 'city_id'         => 'nullable|exists:cities,id',
            // 'neighborhood_id' => 'nullable|exists:neighborhoods,id',
            'notes'        => 'nullable|string|max:5000',
            'is_archived'  => 'boolean',
            'created_by'   => 'nullable|exists:admins,id',

            // -------------------------------------
            // Unique Fields (Updated Properly)
            // -------------------------------------

            // Unique Email (ignore this record)
            'email'        => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('clients', 'email')->ignore($clientId),
            ],

            // Country code validation
            'country_code' => [
                'nullable',
                'string',
                Rule::in(array_keys($phoneLengths)),
            ],

            // Unique Phone (ignore this record)
            'phone'        => [
                'required',
                'string',
                Rule::unique('clients', 'phone')->ignore($clientId),
                function ($attribute, $value, $fail) use ($expectedLength) {
                    if ($expectedLength && strlen(preg_replace('/\D/', '', $value)) != $expectedLength) {
                        $fail("رقم الهاتف يجب أن يحتوي على {$expectedLength} أرقام بناءً على كود الدولة.");
                    }
                },
            ],

            // -------------------------------------
            // Owner Information
            // -------------------------------------

            'national_id'      => [
                'nullable',
                'digits_between:8,20',
                Rule::unique('clients', 'national_id')->ignore($clientId),
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
