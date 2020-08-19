<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020-7-17
 * Time: 11:45
 */

namespace Large\Zhengdada\Listeners;

use Large\Zhengdada\LargeLog\Logs;
use \Illuminate\Database\Events\QueryExecuted;


// 测试 1111
class SqlListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }
    /**
     * Handle the event.
     *
     * @param =QueryExecuted $event
     * @return void
     */
    public function handle(QueryExecuted $event) {
        // 在这里编写业务逻辑
        $sql = str_replace("?", "'%s'", $event->sql);
        $log = $sql;

        if(!is_null(request()->route())){
            if (request()->route()->getName() != 'zbsuser.index.console'){
                $log = vsprintf($sql, $event->bindings);
            }
        }

        // 记录日志/ 2M 分割一次日志
        Logs::mkLogFile('dataLog/sql/'.date('Ymd') , $log);
    }
}