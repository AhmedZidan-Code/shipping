<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetDBConnection
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
        $year = Session::get('year');
        
        if ($year) {
            $this->configureDatabaseConnection($year);
        }

        return $next($request);
    }
    protected function configureDatabaseConnection($year)
    {
        if ($year == '2024') {
            Config::set('database.default', 'mysql');
        } elseif ($year == '2025') {
            Config::set('database.default', 'mysql_second');
        } else {
            Config::set('database.default', 'mysql');
        }
    }
}
