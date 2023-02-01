<?php

namespace Leafwrap\LaravelInstaller\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!file_exists(config_path() . '/installed.php') && !str_contains(request()->url(), 'installer')) {
            return redirect()->route('requirements.index');
        }
        return $next($request);
    }
}
