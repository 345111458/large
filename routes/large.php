<?php

use Illuminate\Support\Facades\Route;
use Large\Zhengdada\Controllers\TestController;


Route::group([
                 "middleware" => ["web"],
             ], function () {


    Route::get('test2', function () {

        dd('测试一下', Cookie::get('language'));
    });

    // 设置语言 路由设置
    Route::get('lang/{lang}', function ($lang) {
        $newLang = strtolower($lang);
        if (in_array($newLang, Config('app.locales'))) {
            Cookie::queue('language', $newLang);
        }
        return redirect()->back();
    });


    Route::post('root_path/{path}', [TestController::class, "dirTree"])->name('root_path');


    Route::get('hhhh', [TestController::class, "index"])->name('hhhh');
//

});

?>
