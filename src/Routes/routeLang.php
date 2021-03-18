<?php

use Illuminate\Support\Facades\Route;


// 设置语言 路由设置
Route::get('lang/{lang}', function($lang){
   $newLang = strtolower($lang);
   if (in_array($newLang , \Config('app.locales'))){
       Cookie::queue('language' , $newLang);
   }
   return redirect()->back();
});







?>