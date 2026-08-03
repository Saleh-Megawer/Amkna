<div class="input-price">
    <x-form-group :properties="[
        'input' => [
            'name' => $options['name'] ?? null,
            'value' => $options['value'] ?? null,
            'type' => 'number',
            'options' => [
                isset($options['required']) ?? 'required',
                'step' => 'any',
                'pattern' => '[0-9]*\.?[0-9]*',
                'placeholder' => $options['placeholder'] ?? null,
                'class' => $options['class'] ?? null,
            ],
        ],
        ...!empty($options['label_text']) ? ['label' => ['text' => $options['label_text']]] : [],
    ]" />
    <div @style(isset($options['icon_top']) ? "top: {$options['icon_top']};" : null) class="append-icon">
        {!! currency_icon() !!}
    </div>

</div>
