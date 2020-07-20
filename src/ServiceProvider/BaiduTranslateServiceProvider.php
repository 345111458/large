<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-20
 * Time: 12:31
 */

namespace Large\Zhengdada\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Large\Zhengdada\BaiduTranslate\BaiduTranslate;


class BaiduTranslateServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(BaiduTranslate::class , function(){

            return new BaiduTranslate(config('services.baidu_translate'));
        });
        $this->app->alias(BaiduTranslate::class , 'baidu');
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__ . '../BaiduTranslate/config.php' => config_path('services.php'),
        ], 'config');

        // 将扩展包默认配置和应用的已发布副本配置合并在一起
        $this->mergeConfigFrom( __DIR__ . '../BaiduTranslate/config.php', 'baidu_translate');

        // 注册扩展包的 Artisan 命令
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                JWTSecretGenerate::class,
//            ]);
//        }

    }

}