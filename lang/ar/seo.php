<?php

return [
    'defaults' => [
        'title'       => 'جميع العقارات للبيع والإيجار في مصر',
        'heading'     => 'جميع العقارات',
        'description' => 'تصفح جميع العقارات للبيع والإيجار في مصر - شقق، فلل، ومحلات على أمكنة',
    ],

    'noun' => [
        'default' => 'عقارات',
    ],

    'purpose' => [
        'sale' => 'للبيع',
        'rent' => 'للإيجار',
    ],

    'location' => [
        'in'      => 'في :place',
        'country' => 'في مصر',
    ],

    'price' => [
        'up_to'   => 'حتى :value :currency',
        'from'    => 'تبدأ من :value :currency',
        'between' => 'من :from إلى :to :currency',
    ],

    'area' => [
        'up_to'   => 'مساحة حتى :value م²',
        'from'    => 'مساحة من :value م²',
        'between' => 'مساحة من :from إلى :to م²',
    ],

    'bedrooms' => [
        'count' => ':count غرف',
        'plus'  => ':count غرف فأكثر',
    ],

    'bathrooms' => [
        'count' => ':count حمام',
        'plus'  => ':count حمامات فأكثر',
    ],

    'payment' => [
        'installment' => 'بالتقسيط',
    ],

    'currency' => 'جنيه',

    'description_suffix' => 'تصفح أفضل العقارات على أمكنة',
];
