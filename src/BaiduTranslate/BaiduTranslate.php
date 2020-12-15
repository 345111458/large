<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-20
 * Time: 11:53
 */

namespace Large\Zhengdada\BaiduTranslate;

use Large\Zhengdada\Functions;
use Overtrue\Pinyin\Pinyin;
use GuzzleHttp\Client;


class BaiduTranslate extends Functions
{

    protected $str;   // 传入一个值，/ - \ 都可以
    protected $appid; // 百度翻译 appid
    protected $key;   // 百度翻译KEY
    protected $http;  // http 请求实例

    public function __construct($arr)
    {
        $this->appid = $arr['appid'];
        $this->key = $arr['key'];
        $this->str = $arr['str'];

        // 实例化 HTTP 客户端
        $this->http = new Client;
    }


    /***
     * @param $text
     * @return mixed|void 查询翻译
     */
    protected function translate($text, $replace = null)
    {
        // 初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $salt = time();

        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($this->appid) || empty($this->key)) {
            return self::pinyin($text , $replace);
        }

        // 根据文档，生成 sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($this->appid. $text . $salt . $this->key);

        // 构建请求参数
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $this->appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // 发送 HTTP Get 请求
        $result = $this->http->get($api.$query)->getBody()->getContents();
        $result = json_decode($result , true);

        // 尝试获取获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            if ($replace) {
                return self::strReplace(" ", $replace, $result['trans_result'][0]['dst']);
            }
            return $result['trans_result'][0]['dst'];
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return self::pinyin($text , $replace) . '_11111111111';
        }
    }


    /***
     * @param $text
     * @return mixed|void 拼音翻译
     */
    protected function pinyin($text , $replace=null)
    {
        $response = app(Pinyin::class)->permalink($text);
        if ($replace) {
            return self::strReplace('-' , $replace, $response);
        }
        return $response;
    }


}