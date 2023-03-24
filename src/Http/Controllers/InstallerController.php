<?php

namespace Leafwrap\LaravelInstaller\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Leafwrap\LaravelInstaller\Traits\Helper;

class InstallerController extends Controller
{
    use Helper;

    public function getExtensions()
    {
        try {
            return $this->entityResponse($this->getRequireExtensions());
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function validateExtensions()
    {
        try {
            foreach ($this->getRequireExtensions() as $item) {
                if (!$item) {
                    return $this->messageResponse('Please enabled the required extensions', 400);
                }
            }
            return $this->messageResponse('Requirement step is completed', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function getPermissions()
    {
        try {
            return $this->entityResponse($this->getRequirePermissions());
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function validatePermissions()
    {
        try {
            foreach ($this->getRequirePermissions() as $item) {
                if (!$item) {
                    return $this->messageResponse('Please enabled the required permissions', 400);
                }
            }
            return $this->messageResponse('Permissions step is completed', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function getProducts()
    {
        try {
            $client = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json', 'Content-Type' => 'application/json',
            ])->get(config('laravel-installer.products_url') . '?page=1&offset=20');
            $client = $client->json();

            if ($client['status'] === 'success') {
                $products = $client['data'];
            }
            return $this->entityResponse([
                'products'            => $products ?? [],
                'selected_product_id' => config('laravel-installer.product_id'),
            ]);
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function validateLicenses()
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
                'product_id' => 'required',
                'code'       => 'required|regex:/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i',
            ]);
            if ($validator->fails()) {
                return $this->validateError($validator->errors());
            }

            $client = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json', 'Content-Type' => 'application/json',
            ])->post(config('laravel-installer.license_url'), [
                'product_id' => request()->input('product_id'),
                'code'       => request()->input('code'),
            ]);
            $client = $client->json();
            return $client;
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function getDatabases()
    {
        try {
            return $this->entityResponse($this->getAppInfo('database'));
        } catch (Exception $e) {
            return $this->serverError($e);
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
                return $this->validateError($validator->errors());
            }

            if (!$this->getDatabaseConnection()) {
                return $this->messageResponse('Please use the correct database credentials', 400);
            }

            return $this->messageResponse('Database step is completed', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }

    public function validateInstallation()
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
                'role_id'    => 'sometimes',
                'first_name' => 'required',
                'last_name'  => 'sometimes',
                'phone'      => 'sometimes',
                'email'      => 'required',
                'password'   => 'required',

            ]);
            if ($validator->fails()) {
                return $this->validateError($validator->errors());
            }

            $model = config('auth.providers.users.model');
            $model::create([
                'role_id'    => 1,
                'first_name' => request()->input('first_name'),
                'last_name'  => request()->input('last_name'),
                'phone'      => request()->input('phone'),
                'email'      => request()->input('email'),
                'password'   => request()->input('password'),
            ]);

            $content = <<<TEXT
            <?php
                return [
                    'installation' => 'Complete',
                ];
            TEXT;
            file_put_contents(config_path() . '/installed.php', $content);
            file_put_contents(storage_path() . '/installed', 'Installed');

            return $this->messageResponse('Installation step is completed', 200, 'success');
        } catch (Exception $e) {
            return $this->serverError($e);
        }
    }
}
