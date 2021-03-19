<?php

use Illuminate\Support\Facades\Route;
use Large\Zhengdada\Controllers\TestController;



Route::get('test2', function (){

    dd('测试一下');
});


// 设置语言 路由设置
Route::get('lang/{lang}', function($lang){
    $newLang = strtolower($lang);
    if (in_array($newLang , \Config('app.locales'))){
        Cookie::queue('language' , $newLang);
    }
    return redirect()->back();
});


Route::get('hhhh', 'TestController@index')->name('hhhh');



?>