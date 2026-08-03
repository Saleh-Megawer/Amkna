<?php
namespace App\Http\Requests\Dashboard\Crm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DealRequest extends FormRequest
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
        $rules = [
            // Client (required)
            // 'client_id'  => 'required|exists:clients,id',
            // Source (optional)
            'source_id'  => 'nullable|exists:sources,id',
            // Status (optional)
            'status_id'  => 'nullable|exists:statuses,id',
            // Budget limits
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0',
            // Rating
            'rating'     => 'nullable|integer|between:1,5',
            // Win flag
            'is_won'     => 'boolean',
            // Notes
            'notes'      => 'nullable|string',
        ];

        // Add created_by ONLY for POST (create) requests
        if ($this->isMethod('POST')) {
            $this->merge([
                'created_by' => adminId(),
            ]);
        }

        return $rules;
    }

}
