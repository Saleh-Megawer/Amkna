<?php
namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
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

    private function allowedPurpose()
    {
        // Types you want to allow
        $allowed = ['rent', 'sale'];

        return array_keys(
            array_intersect_key(config('project.purpose'), array_flip($allowed))
        );
    }

    public function rules(): array
    {

        $rules = [
            'property_type_id' => ['required', Rule::exists('property_types', 'id')],
            'purpose'          => ['required', Rule::in($this->allowedPurpose())],
        ];

        // Validation for translations (Astrotomic)
        foreach (languages() as $key => $lang) {
            $rules["{$key}.title"] = 'required|string|min:3|max:191';
        }

        return $rules;
    }

}
