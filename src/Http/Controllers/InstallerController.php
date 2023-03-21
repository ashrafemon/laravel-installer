<?php

namespace Leafwrap\LaravelInstaller\Http\Controllers;

use App\Http\Controllers\Controller;
use Leafwrap\LaravelInstaller\Traits\Helper;

class InstallerController extends Controller
{
    use Helper;

    public function requirementsView()
    {
        $extensions = $this->getExtensions();
        return view('laravel-installer::pages.requirements', compact('extensions'));
    }

    public function requirementsStore()
    {
        foreach ($this->getExtensions() as $extension) {
            if (!$extension) {
                return redirect()->back()->with(['message' => 'Please enabled the required extension']);
            }
        }
        return redirect()->route('permissions.index');
    }

    public function permissionsView()
    {
        $permissions = $this->getPermissions();
        return view('laravel-installer::pages.permissions', compact('permissions'));
    }

    public function permissionsStore()
    {
        foreach ($this->getPermissions() as $permission) {
            if (!$permission) {
                return redirect()->back()->with(['message' => 'Please enabled the permission of the folders']);
            }
        }
        return redirect()->route('license.index');
    }

    public function licenseView()
    {
        return view('laravel-installer::pages.license');
    }

    public function licenseStore()
    {
        return redirect()->route('database.index');
    }

    public function databaseView()
    {
        $database = $this->getAppInfo('database');
        return view('laravel-installer::pages.database', compact('database'));
    }

    public function databaseStore()
    {
        $checkDB = $this->getDatabaseConnection();
        if (!$checkDB) {
            return redirect()->back()->with(['message' => 'Please use the correct database credentials']);
        }
        return redirect()->route('mail.index');
    }

    public function mailView()
    {
        $mailInfo    = $this->getAppInfo('mail');
        $mailers     = ['smtp', 'ses', 'mailgun', 'postmark', 'sendmail'];
        $encryptions = ['tls', 'ssl'];
        return view('laravel-installer::pages.mail', compact('mailInfo', 'mailers', 'encryptions'));
    }

    public function mailStore()
    {
        $this->setEnvironmentProperty([
            'MAIL_MAILER'     => request()->input('MAIL_MAILER'),
            'MAIL_HOST'       => request()->input('MAIL_HOST'),
            'MAIL_PORT'       => request()->input('MAIL_PORT'),
            'MAIL_ENCRYPTION' => request()->input('MAIL_ENCRYPTION'),
            'MAIL_USERNAME'   => request()->input('MAIL_USERNAME'),
            'MAIL_PASSWORD'   => request()->input('MAIL_PASSWORD'),
        ]);
        return redirect()->route('install.index');
    }

    public function installView()
    {
        return view('laravel-installer::pages.install');
    }

    public function installStore()
    {
        $user = User::create([
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
        return redirect()->route('finish.index');
    }

    public function finishView()
    {
        return view('laravel-installer::pages.finish');
    }

}
