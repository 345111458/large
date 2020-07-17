<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-17
 * Time: 15:10
 */

namespace Large\Zhengdada\Search;

use Large\Zhengdada\Functions;

class Search extends Functions
{

    /****
     * @param array $arr 查询条件数组
     * $page       当前第几页
     * $limit      一次查询多少条数据
     * $parame     要进行搜索的字段
     * $condition  字段搜索方式
     * $excludeField  过滤不须要查询的字段
     * @return array 返回一个数组
     */
    protected function formatWehre($arr = [])
    {
        $page           =   @$arr['page'] ? $arr['page'] : 1;// 当前第几页
        $limit          =   @$arr['limit'] ? $arr['limit'] : 10;// 一次查询多少条数据
        $parame         =   !empty($arr['parame']) ? $arr['parame'] : [];// 要进行搜索的字段
        $condition      =   !empty($arr['condition']) ? $arr['condition'] : [];// 字段搜索方式
        $excludeField   =   @$arr['exclude_field'] ? array_keys($arr['exclude_field']) : [];// 过滤不须要查询的字段

        $where          = [];        // 在where查询的条件
        $exclude        = [];      // 不在where查询的条件，自行处理
        $verify         = false;    // 是否查询，如果为true 进行where查询

        // 循环要搜索的字段。
        foreach ($parame as $k=>$v){
            if (in_array($k , $excludeField)){
                $exclude[$k] = $v;
                continue;
            }

            // 如果有值，就查询
            if (empty($v)){
                continue;
            }else{
                $verify = true;
            }

            $newCon = !empty(@$condition[$k]) ? @$condition[$k] : '%*%';

            switch (strtolower($newCon)){
                case '=':
                    $where[] = [$k , '=' , $v];
                    break;
                case '>':
                    $where[] = [$k , '>' , $v];
                    break;
                case '>=':
                    $where[] = [$k , '>=' , $v];
                    break;
                case '<':
                    $where[] = [$k , '<' , $v];
                    break;
                case '<=':
                    $where[] = [$k , '<=' , $v];
                    break;
                case '%*%':
                    $where[] = [$k , 'LIKE' , "%{$v}%"];
                    break;
                case '*%':
                    $where[] = [$k , 'LIKE' , "{$v}%"];
                    break;
                case '%*':
                    $where[] = [$k , 'LIKE' , "%{$v}"];
                    break;
                case 'between':
                    list($t1,$t2) = explode('/' , $v);
                    $where[] = [$k , 'between' , [$t1 , $t2.' 23:59:59']];
                    break;
            }
        }
        return [$where, $verify, $exclude, $page, $limit];
    }

}