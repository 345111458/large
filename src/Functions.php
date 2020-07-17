<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-17
 * Time: 10:16
 */

namespace Large\Zhengdada;


class Functions
{

    public function __call($method, $parameters)
    {
        return $this->{$method}(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->{$method}(...$parameters);
    }

    /***
     * 判断文件大小
     * @param $fiel 文件目录，
     * @param $size 设定日志文件大小
     */
    protected function judgeFileSize($fiel, $size){

        if (!file_exists($fiel)) return ;

        $fileSize = filesize($fiel); // 获取文件大小

        // 把文件大小设置成 M ,如果大于M 就拷贝一份,在删除文件
        if (round($fileSize / 1024 * 100) / 1024 > $size){
            copy($fiel , $fiel.'_'. date('His'));
            unlink($fiel);
        }
    }

    /***
     * 判断字符串是不是/开头的
     * @param $str 传入字串
     * @return string 返回带 / 开头的字串
     */
    protected function judgeHead($str)
    {
        return strpos($str , '/') === 0 ? $str : '/' . $str;
    }


    /***
     * 判断有没有传入字串 ， 没有用时间做目录名
     * @param $strgin 传入字符串
     * @return false|string|void 判断有没有传入字串 ， 没有用时间做目录名
     */
    protected function judgeDirToEmpty($strgin)
    {
        return empty($strgin) ? date('YmdHis') : $strgin;
    }


    /***
     * @param $str 传入字串
     * @return string 返回固定字串
     */
    protected function dirname($str)
    {
        $newStr = self::judgeDirToEmpty($str);
        $newStr = self::judgeHead($newStr);

        return './directory' . $newStr;
    }





}