<div class="purpose-wrapper mb-3">
    <label class="label required mb-2">الرغبة</label>

    <div class="purpose-options">

        @foreach($purposes as $key => $item)
            <label for="purpose-{{ $key }}"
                class="label-content btn-label-purpose {{ $selected === $key ? 'is-active-purpose' : '' }}">

                <input type="radio" 
                    name="purpose"
                    id="purpose-{{ $key }}"
                    value="{{ $key }}"
                    {{ $selected === $key ? 'checked' : '' }}
                >

                <span class="purpose-option-icon">
                    {!! $item['svg_icon'] !!}
                </span>

                <span class="purpose-option-name">
                    {{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}
                </span>
                
            </label>
        @endforeach

    </div>
</div>
