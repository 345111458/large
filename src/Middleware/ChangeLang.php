<?php

namespace Large\Zhengdada\Middleware;


use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;


class ChangeLang
{


//      \App\Http\Kernel.php  $middlewareGroups = []  文件里设置以下内容
//      \Large\Zhengdada\Middleware\ChangeLang::class,


//    // 设置语言 路由设置
//    Route::get('lang/{lang}', function($lang){
//        $newLang = strtolower($lang);
//        if (in_array($newLang , \Config('app.locales'))){
//            Cookie::queue('language' , $newLang);
//        }
//        return redirect()->back();
//    });

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
