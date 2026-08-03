@php
    $handelNameForLaravelTranslatable = str_replace('[', '-', $name);
    $handelNameForLaravelTranslatable = str_replace(']', '-lara-trans-error', $handelNameForLaravelTranslatable);
@endphp
<div class="form-group {{ $formGroupClass }}">
    @if ($label == true)
        <label
            @foreach ($labelOptions as $key => $val) @if (is_numeric($key)) {{ $val }} @else @php echo $key.'="'.$val.'"'; @endphp @endif @endforeach>{!! $labelText !!}</label>
    @endif



    @if ($input == true)
        <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
            @if (strstr($name, '[]')) {{ 'data-name=' . str_replace('[]', '', $name) }} @endif
            {{ 'data-laravel-translatable=' . $handelNameForLaravelTranslatable }}
            @foreach ($inputOptions as $key => $val)@if (is_numeric($key)){!! $val !!}@else @php echo $key . '="' . $val . '"'; @endphp @endif @endforeach>
    @endif



    @if ($textarea == true)
        <textarea name="{{ $name }}" id="{{ $name }}"
            @if (strstr($name, '[]')) {{ 'data-name=' . str_replace('[]', '', $name) }} @endif
            {{ 'data-laravel-translatable=' . $handelNameForLaravelTranslatable }}
            @foreach ($textareaOptions as $key => $val) @if (is_numeric($key)) {!! $val !!} @else @php echo $key . '="' . $val . '"'; @endphp @endif @endforeach>@php
                echo $value;
            @endphp</textarea>
    @endif


    @if ($select == true)

        @php
            $option_value = null;
            $option_text = null;
        @endphp

        <select name="{{ $name }}" id="{{ $name }}"
            @if (strstr($name, '[]')) {{ 'data-name=' . str_replace('[]', '', $name) }} @endif
            @foreach ($selectOptions as $key => $val) @if (is_numeric($key)) {!! $val !!} @else @php echo $key . '="' . $val . '"'; @endphp @endif @endforeach>

            <!-- $arrayType == 'associative' -->
            @if (isset($list[0]) && is_array($list[0]))

                @foreach ($list as $key => $val)
                    <!-- Check IF Not Have Selected Value Set Empty Option In First -->
                    @php

                        if (is_array($val)) {
                            if (isset($val[$optionValue]) && isset($val[$optionText])) {
                                // Option Value
                                $option_value = $val[$optionValue];
                                $option_text = $val[$optionText];
                            } else {
                                $error =
                                    'Error Make sure you include the following information: <br> value => not exist <br> OR <br> name => not exist';
                            }
                        } else {
                            $option_value = $val;
                            $option_text = $val;
                        }
                        // IF Have Request Set The Old Value Selected
                        if (old($name) != null) {
                            $selected = old($name);
                        }

                    @endphp

                    @if (!$selected)
                        @if ($loop->index == 0)
                            <option value="" selected disabled>
                                @if (isset($selectOptions['placeholder']))
                                    {{ $selectOptions['placeholder'] }}
                                @else
                                    {{-- {{ __('choose') }} --}}
                                @endif
                            </option>
                        @endif
                    @endif

                    <option @selected($selected == $option_value) value="{{ $option_value }}">
                        {{ Str::ucfirst($option_text) }}</option>
                @endforeach
            @else
                @foreach ($list as $opt)
                    <!-- Check IF Not Have Selected Value Set Empty Option In First -->
                    @php

                        if (isset($opt->$optionValue)) {
                            // Option Value
                            $option_value = $opt->$optionValue;
                            //  Option Text For Display
                            $option_text = $opt->$optionText;
                        } else {
                            // Option Value
                            $option_value = $opt;
                            // Option Text For Display
                            $option_text = $opt;
                        }

                        // IF Have Request Set The Old Value Selected
                        if (old($name) != null) {
                            $selected = old($name);
                        }

                    @endphp

                    @if (!$selected)
                        @if ($loop->index == 0)
                            <option value="" selected disabled>
                                @if (isset($selectOptions['placeholder']))
                                    {{ $selectOptions['placeholder'] }}
                                @else
                                    {{-- {{ __('choose') }} --}}
                                @endif
                            </option>
                        @endif
                    @endif

                    <option @selected($isSelected($option_value)) value="{{ $option_value }}">{{ Str::ucfirst($option_text) }}
                    </option>
                @endforeach
            @endif



        </select>

    @endif


    @error($name)
        <span class="error">{{ $message }}</span>
    @enderror

    @if ($error != null)
        <div class="alert alert-danger">{!! $error !!}</div>
    @endif

</div><!-- End FormGroup -->
