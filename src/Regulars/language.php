<?php

namespace Large\Zhengdada\Regulars;

use Overtrue\Pinyin\Pinyin;


class LanguageReplace
{

    protected $url;
    protected $fileName;
    protected $langPrefix;
    protected $langLen;


    /***
     *
     * LanguageReplace constructor.
     * @param $url         | string 文件路径
     * @param $fileName    | string 文件名
     * @param $langPrefix  | string 语言包Key前缀
     * @param $langLen     | string 语言包Key长度
     */
    public function __construct($url, $fileName, $langPrefix = 'xxxxxx', $langLen = 8)
    {
        $this->url        = $url;
        $this->fileName   = $fileName;
        $this->langPrefix = $langPrefix;
        $this->langLen    = $langLen;
    }


    public function replace()
    {
        // 小内存型
        $pinyin = new Pinyin(); // 默认
        # 要替换文件的路径
        $url = $this->url;
        # 要替换文件的文件名
        $file_path = $url.$this->fileName;
        # 把文件读进来
        $file_data = file_get_contents($file_path);
        # 正则规则
        $rules = '/>(.*?)</';
        # 把要替换的内容放这里替换
        $content = preg_replace_callback($rules, function ($str) use ($pinyin) { // $aa 是匹配到的内容
            // 语言包前缀
            $newKey = $this->langPrefix;
            // 把汉字转换成拼音首字母
            $result = $pinyin->abbr($str[1], PINYIN_KEEP_NUMBER);
            //语言包格式定义
            if (strlen($result) >= $this->langLen) {
                // 拼音长度为8
                $str_pad = strtoupper(substr($result, 0, $this->langLen));
            } else {
                // 拼音长度不够8位，右边补X
                $str_pad = strtoupper(str_pad($result, $this->langLen, 'x', STR_PAD_RIGHT));
            }
            // 拼接语言包
            $string = '"'.$newKey.$str_pad.'"'.'    =>  "'.$str[1].'",';
            // 把要替换的语言包写入一个文件
            file_put_contents(__DIR__.'/../resources/lang/zh/test1.php', $string.PHP_EOL, FILE_APPEND);
            // 最终页面替换后的语言包格式
            return ">{{ trans('".$newKey.$str_pad."') }}<";
        }, $file_data);

        // 把替换后的文件写入一个新文件里
        file_put_contents($url."test.blade.php", $content);

//        // 打印出来看看结果
//        dd($content);
    }


}

