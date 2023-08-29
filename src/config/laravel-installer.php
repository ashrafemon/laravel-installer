<?php

return [
    'company_logo'  => env('CODECANYON_COMPANY_LOGO', 'https://ccninfotech.com/uploads/logo.png'),
    'product_id'    => env('CODECANYON_PRODUCT_ID', 0),
    'guideline_url' => env('CODECANYON_PRODUCT_GUIDELINE_URL', 'https://localhost'),
    'support_url'   => env('CODECANYON_SUPPORT_URL', 'https://localhost'),
    'login_url'     => env('CODECANYON_LOGIN_URL', '/login'),
    'products_url'  => env('CODECANYON_PRODUCTS_URL', 'https://license.ccninfotech.com/api/v1/site/products'),
    'license_url'   => env('CODECANYON_LICENSE_URL', 'https://license.ccninfotech.com/api/v1/site/license-check'),
    'product_fetch' => env('CODECANYON_PRODUCT_FETCH', true),
    'license_check' => env('CODECANYON_LICENSE_CHECK', true),
    'role_property' => env('CODECANYON_ROLE_PROPERTY', 'role_id'),
    'name_property' => env('CODECANYON_NAME_PROPERTY', 'first_name'),
    'role_id'       => env('CODECANYON_ROLE_ID', 1),
];
