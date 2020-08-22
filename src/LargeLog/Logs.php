<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-17
 * Time: 10:37
 */

namespace Large\Zhengdada\LargeLog;

use Large\Zhengdada\Functions;
use Large\Zhengdada\Directory\Directory;


class Logs extends Functions
{

    /***
     *  记录日志文件
     * @param $path 文件路径
     * @param $log  日志数据
     * @param int $size 日志文件大小
     */
    protected function mkLogFile($dir, $log = '', $size = 5){

        $logs = '[' . date('Y-m-d H:i:s') . '] ' . $log . "\r\n";

        // 不是目录，创建一个
        if (!file_exists($dir)){
            $dir = Directory::mkdirs($dir , 0755);
        }

        // 设置需保存的文件目录
        $filepath = $dir . self::judgeHead(date('Ymd') . '.log');
        // 判断文件大小
        self::judgeFileSize($filepath , $size);
        // 写入数据
        file_put_contents($filepath, $logs, FILE_APPEND);
        // 这里也可以直接用Log::info() 里的函数，只是这样会和其他调试信息掺在一起。
        // 如果要用Log里的函数，别忘记了引入Log类。
    }
}