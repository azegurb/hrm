<?php

namespace App\Http\Middleware;

use App\Library\Service\Service;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HRAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('API_URL') == 'dev') {
            return $next($request);
        } elseif (env('API_URL') == 'prod') {
            $SSO_TOKEN = isset($_COOKIE['SSO-TOKEN']) ? $_COOKIE['SSO-TOKEN']:null;
            if(is_null($SSO_TOKEN)) {
                return Redirect::away(url('http://accounts.yyyy.com/login?domain='.env('HTTP_ORIGIN')))->send();
            }
            if(!Session::has('authUser')) {
                $user = Service::request([
                    'method'  => 'POST',
                    'url'     => Service::url('auth','getUserInfo' , false),
                    'options' => [
                        'json' => [
                            'sso_token' => $SSO_TOKEN
                        ]
                    ]
                ]);
                session(['authUser' => $user->data]);
                session()->save();
            }
            return $next($request);
        }
    }

}
