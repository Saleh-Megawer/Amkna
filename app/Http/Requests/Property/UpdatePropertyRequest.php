<?php
namespace App\Http\Requests\Property;

use App\Enums\Property\PropertyAvailabilityStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdatePropertyRequest extends FormRequest
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
            'sale_price'                 => ['nullable', 'integer', 'min:100', 'max:999999999'],

            'rent_price_monthly'         => ['nullable', 'integer', 'min:100', 'max:999999999'],
            'rent_price_quarterly'       => ['nullable', 'integer', 'min:100', 'max:999999999'],
            'rent_price_semi_annually'   => ['nullable', 'integer', 'min:100', 'max:999999999'],
            'rent_price_annually'        => ['nullable', 'integer', 'min:100', 'max:999999999'],

            // Area
            'area'                       => ['required', 'numeric', 'min:1', 'max:10000'],

            // Basic property data
            'bedrooms'                   => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms'                  => ['nullable', 'integer', 'min:0', 'max:20'],
            'floor'                      => ['nullable', 'string', 'max:50'],

            // Foreign keys
            'property_type_id'           => ['required', Rule::exists('property_types', 'id')],
            'purpose'                    => ['required', Rule::in($this->allowedPurpose())],
            'facade_id'                  => ['nullable', Rule::exists('property_facades', 'id')],
            'city_id'                    => ['nullable', Rule::exists('cities', 'id')],
            'neighborhood_id'            => ['nullable', Rule::exists('neighborhoods', 'id')],
            'property_status_id'         => ['nullable', Rule::exists('property_statuses', 'id')],
            'property_finishing_type_id' => ['nullable', Rule::exists('property_finishing_types', 'id')],

            // License
            'license_number'             => ['nullable', 'string', 'max:100'],
            // Youtube
            'youtube_video_url'          => ['nullable', 'url', 'max:255', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'plan_number'                => ['nullable', 'string', 'max:100'],
            'plot_number'                => ['nullable', 'string', 'max:100'],
            'number_of_floors'           => ['nullable', 'integer', 'min:1', 'max:100'],
            'google_map_iframe'          => ['nullable', 'string', 'regex:/<iframe.*?google\.com\/maps.*?<\/iframe>/i'],

            // arrays (features + amenities)
            'feature_id'                 => ['nullable', 'array'],
            'feature_id.*'               => ['integer', Rule::exists('property_features', 'id')],
            //
            'amenity_id'                 => ['nullable', 'array'],
            'amenity_id.*'               => ['integer', Rule::exists('property_amenities', 'id')],
            //
            'is_archived'                => ['sometimes', 'boolean'],
            'availability_status'        => ['required', new Enum(PropertyAvailabilityStatus::class)],
        ];

        // Validation for translations (Astrotomic)
        foreach (languages() as $key => $lang) {
            $rules["{$key}.title"]       = 'required|string|min:3|max:191';
            $rules["{$key}.description"] = 'nullable|string|min:5';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [

            // Prices
            'sale_price.integer'                => 'سعر البيع يجب أن يكون رقمًا صحيحًا.',
            'sale_price.min'                    => 'سعر البيع يجب ألا يقل عن 100.',
            'sale_price.max'                    => 'سعر البيع كبير جدًا وغير مسموح به.',

            'rent_price_monthly.integer'        => 'سعر الإيجار الشهري يجب أن يكون رقمًا صحيحًا.',
            'rent_price_monthly.min'            => 'سعر الإيجار الشهري يجب ألا يقل عن 100.',
            'rent_price_monthly.max'            => 'سعر الإيجار الشهري كبير جدًا.',

            'rent_price_quarterly.integer'      => 'سعر الإيجار الربع سنوي يجب أن يكون رقمًا صحيحًا.',
            'rent_price_quarterly.min'          => 'سعر الإيجار الربع سنوي يجب ألا يقل عن 100.',
            'rent_price_quarterly.max'          => 'سعر الإيجار الربع سنوي كبير جدًا.',

            'rent_price_semi_annually.integer'  => 'سعر الإيجار النصف سنوي يجب أن يكون رقمًا صحيحًا.',
            'rent_price_semi_annually.min'      => 'سعر الإيجار النصف سنوي يجب ألا يقل عن 100.',
            'rent_price_semi_annually.max'      => 'سعر الإيجار النصف سنوي كبير جدًا.',

            'rent_price_annually.integer'       => 'سعر الإيجار السنوي يجب أن يكون رقمًا صحيحًا.',
            'rent_price_annually.min'           => 'سعر الإيجار السنوي يجب ألا يقل عن 100.',
            'rent_price_annually.max'           => 'سعر الإيجار السنوي كبير جدًا.',

            // Area
            'area.required'                     => 'المساحة مطلوبة.',
            'area.numeric'                      => 'المساحة يجب أن تكون رقمًا.',
            'area.min'                          => 'المساحة يجب ألا تقل عن 1 متر.',
            'area.max'                          => 'المساحة المدخلة كبيرة جدًا.',

            // Basic numbers
            'bedrooms.integer'                  => 'عدد الغرف يجب أن يكون رقمًا صحيحًا.',
            'bedrooms.min'                      => 'عدد الغرف لا يمكن أن يكون أقل من 0.',
            'bedrooms.max'                      => 'عدد الغرف لا يمكن أن يتجاوز 20.',

            'bathrooms.integer'                 => 'عدد دورات المياه يجب أن يكون رقمًا صحيحًا.',
            'bathrooms.min'                     => 'عدد دورات المياه لا يمكن أن يكون أقل من 0.',
            'bathrooms.max'                     => 'عدد دورات المياه لا يمكن أن يتجاوز 20.',

            'floor.string'                      => 'رقم الدور يجب أن يكون نصًا.',
            'floor.max'                         => 'رقم الدور طويل جدًا.',

            // Foreign keys
            'facade_id.exists'                  => 'الواجهة المختارة غير صحيحة.',
            'city_id.exists'                    => 'المدينة المختارة غير صحيحة.',
            'neighborhood_id.exists'            => 'الحي المختار غير صحيح.',
            'property_status_id.exists'         => 'حالة العقار غير صحيحة.',
            'property_finishing_type_id.exists' => 'نوع التشطيب غير صحيح.',

            // License
            'license_number.string'             => 'رقم الترخيص يجب أن يكون نصًا.',
            'license_number.max'                => 'رقم الترخيص طويل جدًا.',

            // Youtube
            'youtube_video_url.url'             => 'رابط الفيديو يجب أن يكون رابطًا صحيحًا.',
            'youtube_video_url.regex'           => 'يجب إدخال رابط يوتيوب صحيح.',

            // Plan & plot
            'plan_number.string'                => 'رقم المخطط يجب أن يكون نصًا.',
            'plan_number.max'                   => 'رقم المخطط طويل جدًا.',

            'plot_number.string'                => 'رقم القطعة يجب أن يكون نصًا.',
            'plot_number.max'                   => 'رقم القطعة طويل جدًا.',

            // Floors
            'number_of_floors.integer'          => 'عدد الأدوار يجب أن يكون رقمًا.',
            'number_of_floors.min'              => 'عدد الأدوار يجب ألا يقل عن 1.',
            'number_of_floors.max'              => 'عدد الأدوار كبير جدًا.',

            // Google iframe
            'google_map_iframe.regex'           => 'يجب إدخال كود خريطة Google Map صالح.',

            // features + amenities
            'feature_id.array'                  => 'قائمة المميزات غير صحيحة.',
            'feature_id.*.integer'              => 'كل ميزة يجب أن تكون رقمًا صحيحًا.',
            'feature_id.*.exists'               => 'إحدى المميزات المحددة غير موجودة.',

            'amenity_id.array'                  => 'قائمة وسائل الراحة غير صحيحة.',
            'amenity_id.*.integer'              => 'كل وسيلة راحة يجب أن تكون رقمًا صحيحًا.',
            'amenity_id.*.exists'               => 'إحدى وسائل الراحة المحددة غير موجودة.',
        ];

        foreach (languages() as $key => $lang) {

            $langName = $lang['name']; // هنا نجيب اسم اللغة فقط

            $messages["{$key}.title.required"] = "عنوان العقار ({$langName}) مطلوب.";
            $messages["{$key}.title.string"]   = "عنوان العقار ({$langName}) يجب أن يكون نصًا.";
            $messages["{$key}.title.min"]      = "عنوان العقار ({$langName}) قصير جدًا.";
            $messages["{$key}.title.max"]      = "عنوان العقار ({$langName}) طويل جدًا.";

            $messages["{$key}.description.string"] = "الوصف ({$langName}) يجب أن يكون نصًا.";
            $messages["{$key}.description.min"]    = "الوصف ({$langName}) قصير جدًا.";
        }

        return $messages;
    }

}
