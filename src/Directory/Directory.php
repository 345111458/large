<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-16
 * Time: 15:08
 */
namespace Large\Zhengdada\Directory;

use Large\Zhengdada\Functions;

class Directory extends Functions
{
    /***
     * 调用后，创建目录，文件，只把文件创建到入口文件
     * 返回创建后的路径
     * @return string
     */
    protected function mkdirs($dir = '' , $chmod = 0755)
    {
        // 判断有没有配置域名
        if (!in_array($_SERVER['HTTP_HOST'] , ['localhost','127.0.0.1'])) {
            $dir = self::dirname($dir);
        }

        if(\is_dir($dir) || @mkdir($dir,$chmod)){ //查看目录是否已经存在或尝试创建，加一个@抑制符号是因为第一次创建失败，会报一个“父目录不存在”的警告。
            //echo $dir."创建成功<br>";  //输出创建成功的目录
            return $dir;
        }else{
            $dirArr = \explode('/',$dir); //当子目录没创建成功时，试图创建父目录，用explode()函数以'/'分隔符切割成一个数组
            \array_pop($dirArr); //将数组中的最后一项（即子目录）弹出来，
            $newDir = \implode('/',$dirArr); //重新组合成一个文件夹字符串
            self::mkdirs($newDir , $chmod); //试图创建父目录

            if(@mkdir($dir,$chmod)){
                //echo $dir."创建成功<br>";
            } //再次试图创建子目录,成功输出目录名 111111 333
        }
        return $dir;
    }


}