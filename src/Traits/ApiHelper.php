<?php

namespace Leafwrap\LaravelInstaller\Traits;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait ApiHelper
{
    protected function installerServerError($exception)
    {
        return response(['status' => 'server_error', 'statusCode' => 500, 'message' => $exception->getMessage()], 500);
    }

    protected function installerValidateError($data, $override = false)
    {
        $errors       = [];
        $errorPayload = !$override ? $data->getMessages() : $data;

        foreach ($errorPayload as $key => $value) {
            $errors[$key] = $value[0];
        }

        return response(['status' => 'validate_error', 'statusCode' => 422, 'data' => $errors], 422);
    }

    protected function installerMessageResponse($message = 'No data found', $statusCode = 404, $status = 'error')
    {
        return response(['status' => $status, 'statusCode' => $statusCode, 'message' => $message], $statusCode);
    }

    protected function installerEntityResponse($data = null, $statusCode = 200, $status = 'success', $message = null)
    {
        $payload = ['status' => $status, 'statusCode' => $statusCode, 'data' => $data];

        if ($message) {
            $payload['message'] = $message;
        }

        return response($payload, $statusCode);
    }

    private function getRequireExtensions()
    {
        return config('laravel-constants.extensions');
    }

    private function getRequirePermissions()
    {
        return config('laravel-constants.permissions');
    }

    private function getDatabaseConnection()
    {
        try {
            $driver = env('DB_CONNECTION');
            if (!in_array($driver, ['mysql', 'pgsql', 'sqlsrv'])) {
                return false;
            }

            config('database.connections', [
                $driver => [
                    'host'     => request()->input('DB_HOST'),
                    'port'     => request()->input('DB_PORT'),
                    'database' => request()->input('DB_DATABASE'),
                    'username' => request()->input('DB_USERNAME'),
                    'password' => request()->input('DB_PASSWORD'),
                ],
            ]);
            if (!DB::connection()->getPDO()) {
                return false;
            }

            Artisan::call('optimize:clear');

            $model = config('auth.providers.users.model');
            if (!$model::query()->first()) {
                Artisan::call('migrate:fresh --seed');
            } else {
                Artisan::call('migrate');
            }

            $this->setEnvironmentProperty([
                'APP_URL'     => request()->getSchemeAndHttpHost(),
                'APP_DEBUG'   => false,
                'DB_HOST'     => request()->input('DB_HOST'),
                'DB_PORT'     => request()->input('DB_PORT'),
                'DB_DATABASE' => request()->input('DB_DATABASE'),
                'DB_USERNAME' => request()->input('DB_USERNAME'),
                'DB_PASSWORD' => request()->input('DB_PASSWORD'),
            ]);
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
                'APP_URL'   => request()->getSchemeAndHttpHost() ?? env('APP_URL'),
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
                    $str .= $envKey . "=" . $envValue . "'\n";
                } else {
                    $str = str_replace($oldLine, $envKey . "=" . $envValue, $str);
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
