<div class="ltr mb-2">
    <span class="required"></span>
    رقم الهاتف
</div>

<div class="phone-inputs">


 
    <div style="margin-top: 20px" class="input-flags">
        <select name="country_code" class="form-control choices-country">
            @foreach ($globalPhoneData['countries'] as $country)
                <option value="{{ $country['code'] }}" data-flag="{{ $country['flag'] }}" @selected($country['code'] == ($code ?? old('country_code')))>
                    {{ $country['code'] }}
                </option>
            @endforeach
        </select>
    </div>
 
    <div class="input-phone input-normal-style">
        <x-form-group :properties="[
            'input' => [
                'type' => 'phone',
                'name' => 'phone',
                'value' => $phone ?? old('phone'),
                'options' => ['required'],
            ],
        ]" />
    </div><!-- phone -->

</div><!-- phone-inputs -->
