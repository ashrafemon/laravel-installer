<?php

return [
    'extensions'  => [
        ['title' => 'PHP >= 8.0', 'value' => phpversion() >= 8.0, 'text' => phpversion()],
        ['title' => 'MySqli PHP Extension', 'value' => extension_loaded('bcmath'), 'text' => extension_loaded('bcmath') ? 'Enable' : 'Disable'],
        ['title' => 'PDO PHP Extension', 'value' => extension_loaded('pdo'), 'text' => extension_loaded('pdo') ? 'Enable' : 'Disable'],
        ['title' => 'BCMath PHP Extension', 'value' => extension_loaded('bcMath'), 'text' => extension_loaded('bcMath') ? 'Enable' : 'Disable'],
        ['title' => 'Ctype PHP Extension', 'value' => extension_loaded('cType'), 'text' => extension_loaded('cType') ? 'Enable' : 'Disable'],
        ['title' => 'FileInfo PHP Extension', 'value' => extension_loaded('fileInfo'), 'text' => extension_loaded('fileInfo') ? 'Enable' : 'Disable'],
        ['title' => 'JSON PHP Extension', 'value' => extension_loaded('json'), 'text' => extension_loaded('json') ? 'Enable' : 'Disable'],
        ['title' => 'Mbstring PHP Extension', 'value' => extension_loaded('mbString'), 'text' => extension_loaded('mbString') ? 'Enable' : 'Disable'],
        ['title' => 'OpenSSL PHP Extension', 'value' => extension_loaded('openSSL'), 'text' => extension_loaded('openSSL') ? 'Enable' : 'Disable'],
        ['title' => 'Tokenizer PHP Extension', 'value' => extension_loaded('tokenizer'), 'text' => extension_loaded('tokenizer') ? 'Enable' : 'Disable'],
        ['title' => 'XML PHP Extension', 'value' => extension_loaded('xml'), 'text' => extension_loaded('xml') ? 'Enable' : 'Disable'],
        ['title' => 'cURL PHP Extension', 'value' => extension_loaded('curl'), 'text' => extension_loaded('curl') ? 'Enable' : 'Disable'],
        ['title' => 'GD PHP Extension', 'value' => extension_loaded('gd'), 'text' => extension_loaded('gd') ? 'Enable' : 'Disable'],
        ['title' => 'Zip PHP Extension', 'value' => extension_loaded('zip'), 'text' => extension_loaded('zip') ? 'Enable' : 'Disable'],
        ['title' => 'Allow Url FOpen', 'value' => ini_get('allow_url_fopen'), 'text' => ini_get('allow_url_fopen') ? 'Enable' : 'Disable'],
    ],
    'permissions' => [
        ['title' => 'uploads/files', 'value' => is_writable(public_path() . '/uploads/files')],
        ['title' => 'uploads/images', 'value' => is_writable(public_path() . '/uploads/images')],
        ['title' => 'uploads/videos', 'value' => is_writable(public_path() . '/uploads/videos')],
    ],
    'products'    => [],
];
