<?php

namespace App\Http\Requests\Admin\Profile;

use App\Models\Dashboard\Languages;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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

        // Fetch Languages From DB
        $languages = Languages::select('id')->get();
        $languages_ids = [];

        // Append Ids in Empty Array For Validate
        foreach ($languages as $lang) {
            array_push($languages_ids, $lang->id);
        }

        return [
            'language' => 'nullable|in:' . implode(",", $languages_ids),
            'status' => 'required|in:' . implode(",", config('dashboard.status'))
        ];
    }
}
