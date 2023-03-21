<?php

return [
    'product_id'    => env('CODECANYON_PRODUCT_ID', 0),
    'guideline_url' => env('CODECANYON_PRODUCT_GUIDELINE', 'https://localhost'),
    'support_url'   => env('CODECANYON_SUPPORT', 'https://localhost'),
    'products'      => [
        ['name' => 'Movie flix', 'value' => 1],
        ['name' => 'Openai GPT-3.5', 'value' => 2],
    ],
];
