<?php

namespace Leafwrap\LaravelInstaller\Traits;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait Helper
{
    private function getExtensions()
    {
        return [
            'phpVersion'    => phpversion() >= 8.0,
            'bcMath'        => extension_loaded('bcmath'),
            'cType'         => extension_loaded('ctype'),
            'fileInfo'      => extension_loaded('fileinfo'),
            'json'          => extension_loaded('json'),
            'mbString'      => extension_loaded('mbstring'),
            'openSSL'       => extension_loaded('openssl'),
            'pdo'           => extension_loaded('pdo'),
            'tokenizer'     => extension_loaded('tokenizer'),
            'xml'           => extension_loaded('xml'),
            'mysqli'        => extension_loaded('mysqli'),
            'gd'            => extension_loaded('gd'),
            'zip'           => extension_loaded('zip'),
            'allowUrlFOpen' => ini_get('allow_url_fopen'),
        ];
    }

    private function getPermissions()
    {
        return [
            'files'  => is_writable(public_path() . '/uploads/files'),
            'images' => is_writable(public_path() . '/uploads/images'),
            'videos' => is_writable(public_path() . '/uploads/videos'),
        ];
    }

    private function getDatabaseConnection()
    {
        try {
            $driver = env('DB_CONNECTION');
            if (!in_array($driver, ['mysql', 'pgsql', 'sqlsrv'])) {
                return false;
            }
            $this->setEnvironmentProperty([
                'APP_URL'     => url(''),
                'DB_HOST'     => request()->input('DB_HOST'),
                'DB_PORT'     => request()->input('DB_PORT'),
                'DB_DATABASE' => request()->input('DB_DATABASE'),
                'DB_USERNAME' => request()->input('DB_USERNAME'),
                'DB_PASSWORD' => request()->input('DB_PASSWORD'),
            ]);
            if (!DB::connection()->getPDO()) {
                return false;
            }

            Artisan::call('migrate:fresh --seed');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getAppInfo($type)
    {
        if ($type === 'app') {
            return [
                'APP_NAME'  => env('APP_NAME'),
                'APP_URL'   => url('') ?? env('APP_URL'),
                'APP_DEBUG' => env('APP_DEBUG'),
                'APP_ENV'   => env('APP_ENV'),
            ];
        } elseif ($type === 'mail') {
            return [
                'MAIL_MAILER'     => env('MAIL_MAILER'),
                'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
                'MAIL_HOST'       => env('MAIL_HOST'),
                'MAIL_PORT'       => env('MAIL_PORT'),
                'MAIL_USERNAME'   => env('MAIL_USERNAME'),
                'MAIL_PASSWORD'   => env('MAIL_PASSWORD'),
            ];
        } elseif ($type === 'database') {
            return [
                'DB_CONNECTION' => env('DB_CONNECTION'),
                'DB_HOST'       => env('DB_HOST'),
                'DB_PORT'       => env('DB_PORT'),
                'DB_DATABASE'   => env('DB_DATABASE'),
                'DB_USERNAME'   => env('DB_USERNAME'),
                'DB_PASSWORD'   => env('DB_PASSWORD'),
            ];
        } else {
            return [];
        }
    }

    private function setEnvironmentProperty($payload)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($payload) > 0) {
            foreach ($payload as $envKey => $envValue) {
                $str .= "\n";
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}=" . '"' . $envValue . '"' . "'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
}
