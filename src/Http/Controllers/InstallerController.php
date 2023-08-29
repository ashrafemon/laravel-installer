<?php

namespace Leafwrap\LaravelInstaller\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Leafwrap\LaravelInstaller\Traits\ApiHelper;

class InstallerController extends Controller
{
    use ApiHelper;

    public function getExtensions()
    {
        try {
            return $this->installerEntityResponse($this->getRequireExtensions());
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function validateExtensions()
    {
        try {
            foreach ($this->getRequireExtensions() as $item) {
                if (!$item['value']) {
                    return $this->installerMessageResponse('Please enabled the required extensions', 400);
                }
            }
            return $this->installerEntityResponse(['url' => '/installer/permissions'], 200, 'success', 'Requirement step is completed');
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function getPermissions()
    {
        try {
            return $this->installerEntityResponse($this->getRequirePermissions());
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function validatePermissions()
    {
        try {
            foreach ($this->getRequirePermissions() as $item) {
                if (!$item['value']) {
                    return $this->installerMessageResponse('Please enabled the required permissions', 400);
                }
            }

            $url = config('laravel-installer.license_check') ? '/installer/license' : '/installer/database';
            return $this->installerEntityResponse(['url' => $url], 200, 'success', 'Permissions step is completed');
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function getProducts()
    {
        try {
            $products = config('laravel-constants.products');

            if (config('laravel-installer.product_fetch')) {
                $client = \Illuminate\Support\Facades\Http::withHeaders([
                    'Accept' => 'application/json', 'Content-Type' => 'application/json',
                ])->get(config('laravel-installer.products_url') . '?page=1&offset=100');
                $client = $client->json();

                if ($client['status'] === 'success') {
                    $products = $client['data'];
                }
            }

            return $this->installerEntityResponse([
                'products'            => $products ?? [],
                'selected_product_id' => config('laravel-installer.product_id'),
            ]);
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function validateLicenses()
    {
        try {
            if (config('laravel-installer.license_check')) {
                $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
                    'product_id' => 'required',
                    'code'       => 'required|regex:/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i',
                ]);
                if ($validator->fails()) {
                    return $this->installerValidateError($validator->errors());
                }

                $client = \Illuminate\Support\Facades\Http::withHeaders([
                    'Accept' => 'application/json', 'Content-Type' => 'application/json',
                ])->post(config('laravel-installer.license_url'), [
                    'product_id' => request()->input('product_id'),
                    'code'       => request()->input('code'),
                ]);
                $client = $client->json();
                return $client;
            }
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function getDatabases()
    {
        try {
            return $this->installerEntityResponse($this->getAppInfo('database'));
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function validateDatabases()
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
                'DB_HOST'     => 'required',
                'DB_PORT'     => 'required',
                'DB_DATABASE' => 'required',
                'DB_USERNAME' => 'required',
                'DB_PASSWORD' => 'sometimes',
            ]);
            if ($validator->fails()) {
                return $this->installerValidateError($validator->errors());
            }

            if (!$this->getDatabaseConnection()) {
                return $this->installerMessageResponse('Please use the correct database credentials', 400);
            }

            return $this->installerEntityResponse(['url' => '/installer/install'], 200, 'success', 'Database step is completed');
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }

    public function validateInstallation()
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
                config('laravel-installer.role_property') => 'sometimes',
                config('laravel-installer.name_property') => 'required',
                'last_name'                               => 'sometimes',
                'phone'                                   => 'sometimes',
                'email'                                   => 'required',
                'password'                                => 'required',
            ]);
            if ($validator->fails()) {
                return $this->installerValidateError($validator->errors());
            }

            $model   = config('auth.providers.users.model');
            $payload = [
                config('laravel-installer.role_property') => config('laravel-installer.role_id'),
                config('laravel-installer.name_property') => request()->input(config('laravel-installer.name_property')),
                'last_name'                               => request()->input('last_name'),
                'phone'                                   => request()->input('phone'),
                'email'                                   => request()->input('email'),
                'password'                                => request()->input('password'),
            ];

            if (config('laravel-installer.extra_properties')) {
                $properties       = explode(',', config('laravel-installer.extra_properties'));
                $customProperties = [];
                foreach ($properties as $property) {
                    $propertyArr                       = explode('=', $property);
                    $customProperties[$propertyArr[0]] = $propertyArr[1];
                }
                $payload = array_merge($payload, $customProperties);
            }

            $model::create($payload);

            $content = <<<TEXT
            <?php
                return [
                    'installation' => 'Complete',
                ];
            TEXT;
            file_put_contents(config_path() . '/installed.php', $content);
            file_put_contents(storage_path() . '/installed', 'Installed');

            return $this->installerEntityResponse(['url' => '/installer/finish'], 200, 'success', 'Installation step is completed');
        } catch (Exception $e) {
            return $this->installerServerError($e);
        }
    }
}
