<?php

namespace Large\Zhengdada\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Large\Zhengdada\BaiduTranslate\BaiduTranslate;
use Large\Zhengdada\Functions;


class LangTranslateJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $str; // 要翻译的字符串
    protected $lang; // 要翻译的字符串

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($str, $lang = 'en', $ttl = 5)
    {
        $this->str  = $str;
        $this->lang = $lang;

        // 延时多久后在执行队列
        $this->delay($ttl);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $baidu = new BaiduTranslate($this->lang);
        $results = Functions::getArrayKeyToValue($this->str);
        $result  = '"'.$results[0].'"'.'   =>  '.
            '"'.$baidu->translate($results[1]).'",';


        $dir = resource_path('lang/zh').'/en1111111.php';// 创建目录

        file_put_contents($dir, $result.PHP_EOL, FILE_APPEND);//写入内容
    }
}
