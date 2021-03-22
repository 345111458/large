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

        /**
         * 注册路由
         * Perform post-registration booting of services.
         * 如果扩展包包含路由，可以使用 loadRoutesFrom 方法加载它们
         */
        if (file_exists($routes = $this->routePath())) {
            $this->loadRoutesFrom($routes);
        }
        // 注册Route目录下的large.php文件为路由
        if (file_exists($routes = base_path('routes/large.php'))) {
            $this->loadRoutesFrom($routes);
        }

        //注册 resources 视图文件
        $this->loadViewsFrom($this->viewPath(), 'large');
        // 注册视图文件里的 语言文件
        $this->loadTranslationsFrom(__DIR__.'/path/to/translations', 'large');

        // $this->mergeConfigFrom(dirname(__DIR__) . '/BaiduTranslate/config.php', 'services');// 感觉没有什么用
        // $configPath = dirname(__DIR__) . '/BaiduTranslate/config.php';
        // $this->mergeConfigFrom($configPath, 'services');
    }


    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        // print_r($this->app['config']->get('services'));
        // 发布配置文件
        // 可以查看文档： https://xueyuanjun.com/post/19515.html#toc_2
        if ($this->app->runningInConsole()) {
            $this->publishes([$this->baidu_config() => config_path('baidu_config.php')], 'baidu-config');
            $this->publishes([$this->lang() => base_path('lang.sh')], 'lang-config');
            $this->publishes([$this->routePath() => base_path('routes/large.php')], 'large-route');
            $this->publishes([$this->publicPath() => base_path('public/')], 'public-static');

            $this->publishes([
                                 $this->langPath() => resource_path('lang/vendor'),
                                 $this->viewPath() => resource_path('views/vendor'),
                             ], "large-resources");
        }


        // 如果你的扩展包包含数据库迁移，可以使用 loadMigrationsFrom 方法告知 Laravel 如何加载它们。
        // loadMigrationsFrom 方法接收扩展包迁移的路径作为其唯一参数：
        // $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');


        // 要在 Laravel 中注册扩展包视图，需要告诉 Laravel 视图在哪，可以使用服务提供者的 loadViewsFrom 方法
        // $this->loadViewsFrom(__DIR__.'/path/to/views', 'courier');

        // 注册扩展包的 Artisan 命令
        // if ($this->app->runningInConsole()) {
        //    $this->commands([
        //        JWTSecretGenerate::class,
        //    ]);
        // }

    }

    protected function publicPath()
    {
        return __DIR__.'/../../public/';
    }

    protected function routePath()
    {
        return __DIR__.'/../../routes/large.php';
    }

    protected function resourcesPath()
    {
        return __DIR__.'/../../resouects/';
    }

    protected function configPath()
    {
        return __DIR__.'/../../config/';
    }

    protected function lang()
    {
        return $this->configPath().'lang.sh';
    }

    protected function baidu_config()
    {
        return $this->configPath().'baidu_config.php';
    }

    protected function langPath()
    {
        return $this->resourcesPath().'lang/';
    }

    protected function viewPath()
    {
        return $this->resourcesPath().'views/';
    }


}
