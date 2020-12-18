<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-20
 * Time: 12:31
 */

namespace Large\Zhengdada\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Large\Zhengdada\BaiduTranslate\BaiduTranslate;


class BaiduTranslateServiceProvider extends ServiceProvider
{

    public function register()
    {
        // 设置一个单列
        $this->app->singleton(BaiduTranslate::class, function () {

            return new BaiduTranslate(config('baidu_translate'));
        });
        $this->app->alias(BaiduTranslate::class, 'baidu');

        // $this->mergeConfigFrom(dirname(__DIR__) . '/BaiduTranslate/config.php', 'services');// 感觉没有什么用
        // $configPath = dirname(__DIR__) . '/BaiduTranslate/config.php';
        // $this->mergeConfigFrom($configPath, 'services');
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // print_r($this->app['config']->get('services'));
        // 发布配置文件
        // 可以查看文档： https://xueyuanjun.com/post/19515.html#toc_2
        $this->publishes([
            dirname(__DIR__).'/BaiduTranslate/config.php' => config_path('baidu_translate.php'), // 要创建配置文件的文件
        ], 'config');


        /**
         * Perform post-registration booting of services.
         * 如果扩展包包含路由，可以使用 loadRoutesFrom 方法加载它们
         * @return void
         */
        // $this->loadRoutesFrom(__DIR__.'/routes.php');


        //如果你的扩展包包含数据库迁移，可以使用 loadMigrationsFrom 方法告知 Laravel 如何加载它们。
        // loadMigrationsFrom 方法接收扩展包迁移的路径作为其唯一参数：
        // $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');


        // 要在 Laravel 中注册扩展包视图，需要告诉 Laravel 视图在哪，可以使用服务提供者的 loadViewsFrom 方法
        // $this->loadViewsFrom(__DIR__.'/path/to/views', 'courier');


        // 注册扩展包的 Artisan 命令
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                JWTSecretGenerate::class,
//            ]);
//        }

    }

}