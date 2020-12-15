<?php

namespace Large\Zhengdada\Middleware;


use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;


class ChangeLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Cookie::has('language') && in_array(Cookie::get('language'), Config::get('app.locales'))){
            App::setLocale(Cookie::get('language'));
        }else{
            App::setLocale(Config::get('app.locale'));
        }

        return $next($request);
    }
}
