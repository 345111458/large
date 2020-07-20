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


    /***
     * @param int $length 字串长度
     * @return string
     * @throws \Exception 生成一个随机的数字字符串
     */
    protected function getRandomNumCode($length = 6)
    {
        $code = '';
        for ($i = 0; $i < $length; $i ++) {
            $randNum = random_int(0, 9);
            $code .= $randNum;
        }
        return $code;
    }


    /***
     * @param $fileSize 文件路径
     * @return float|int|string 返回文件在大小
     */
    protected function convertFileSize($fileSize)
    {
        // 1.初始化单位大小
        $k = 1024;  // 单位KB
        $m = $k * $k;  // 单位MB
        $g = $m * $k;  // 单位G
        $t = $g * $k;  // 单位T

        // 2.获取到文件的单位值
        $unit = 'B';
        if (preg_match('/^(\d+)([a-zA-Z]+)$/', $fileSize, $match)) {
            $fileSize = $match[1];  // 获取文件大小，不包括单位值
            $unit = $match[2];  // 根据正则表达式来匹配到对应的单位值
        }

        // 4.把不同的单位大小，都转化为统一的单位B
        switch (strtoupper($unit)) {
            case substr($unit,0, 1) === 'B':
                break;
            case substr($unit,0, 1) === 'K':
                $fileSize *= $k;
                break;
            case substr($unit,0, 1) === 'M':
                $fileSize *= $m;
                break;
            case substr($unit,0, 1) === 'G':
                $fileSize *= $g;
                break;
            case substr($unit,0, 1) === 'T':
                $fileSize *= $t;
                break;
            default:
                api_error(ApiReturnCode::API_RETURN_CODE_UNKNOWN_FILE_UNIT);
                break;
        }

        // 5.自动把文件大小转化为一个合适的单位值
        if ($fileSize >= $t) {
            $fileSize = round($fileSize / $t, 2) . 'T';
        } else if ($fileSize >= $g) {
            $fileSize = round($fileSize / $g, 2) . 'G';
        } else if ($fileSize >= $m) {
            $fileSize = round($fileSize / $m, 2) . 'MB';
        } else if ($fileSize >= $k) {
            $fileSize = round($fileSize / $k, 2) . 'KB';
        } else {
            $fileSize .= 'B';
        }

        // 6.然后返回文件大小
        return $fileSize;
    }


    /**
     * 生成一个邮箱验证的token值
     * @param array $data
     * @param string $join
     * @return string
     */
    protected function getEmailVerifyToken(array $data, $join = '-') :string
    {
        $sign = md5($data['email'] . $join . $data['time']) . $join . $data['state'];
        // 进行hmac-sha256加密
        $token = hash_hmac('sha256', $sign, config('app.key'));
        return $token;
    }



    /**
     * 计算自身下的所有会员,返回所有ID
     * @param $members
     * @param $mid
     * @param $times 传过来的时间
     */
    function GetMemberTeamId($members, $mid , $times = ''){
        $Teams = array($mid);//最终结果
        $mids = array($mid);//第一次执行时候的用户id
        do{
            $othermids = array();
            $state = false;
            foreach ($mids as $v) {
                foreach($members as $k => $memeber) {
                    if($memeber['tjr_id'] == $v){
                        $Teams[]        = $memeber['id'];//找到我的下级立即添加到最终结果中
                        $othermids[]    = $memeber['id'];//将我的下级id保存起来用来下轮循环他的下级
                        unset($members[$k]);// 从大数组里删除 ，运行要快100倍
                        $state=true;
                    }
                }
            }
            $mids = $othermids; //foreach中找到的我的下级集合,用来下次循环
        }while($state == true);

        return $Teams;
    }



    /**
     * 把一个数组进行树形结构排序（使用迭代的方式来实现）数据排序的方式是：merge
     * @param array $data 传入大数组
     * @param int $id 要查询的父ID值
     * @param int $level  层级
     * @param string $column 父ID字段
     * @return array 返回一个数组
     */
    public static function getTreeData($data, $column='pid', $id=0, $level = 1, $join = '----') :array
    {
        $ids = [$id];  // 父id列表
        $treeData = [];  // 要返回的数组
        while ($ids) {  // 判断父id列表是否为空，如果为空就停止循环
            $pid = end($ids);  // 获取父id列表中最后一个元素
            $isDelete = true;  // 默认值为true，当$data数组为空的时候，会删除$ids里面多余的值
            foreach ($data as $k => $value) {
                if ($value[$column] === $pid) {  // 判断该值里面的pid是不是等于父id列表里面的最后一个元素，如果是就进行入栈操作
                    $value['level'] = $level;  // 写入层次到当前数据里面
                    if (isset($value['name'])) {
                        $value['name'] = ($join ? '|' : '') . str_repeat($join, $value['level']) . $value['name'];
                    }
                    $treeData[] = $value;  // 把当前数据写入到要返回的数组里面
                    array_push($ids, $value['id']);  // 入栈，把当前id写入到父id列表中
                    unset($data[$k]);  // 删除当前数组的值，避免下次循环时找到的还是这个数据
                    $level ++;  // 在当前层次上面加一
                    $isDelete = false;  // 设置值为false
                    break 1;  // 退出当前循环
                }
            }
            if ($isDelete) {  // 判断是否进行出栈操作，如果该值等于true，就会进行出栈操作
                array_pop($ids);  // 出栈，删除当前父id列表中的最后一个元素
                $level --; // 在当前层次上面减一
            }
        }
        return $treeData;  // 返回按照树形结构排序以后的数据
    }


    /***
     * @param $find 要查找的值
     * @param $replace 替换的内容
     * @param $text 替换的数据
     * @return mixed|void 字串替换
     */
    protected function strReplace($find, $replace, $text)
    {
        return str_replace($find, $replace, $text);
    }


}