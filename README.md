<h1 align="center"> zhengdada </h1>

<p align="center"> 常用工具包.</p>


## Installing

```shell
$ composer require large/zhengdada -vvv
```



## 创建目录用法

1. use Large\Zhengdada\Directory\Directory;
2. Directory::mkdirs($dir = '' , $chmod = 0755)  
$dir：要创建的目录;  
$chmod：文件权限 默认:0755;  
## 结束


## 自定义 记录日志 方法

1. use Large\Zhengdada\LargeLog;
2. Logs::mkLogFile($dir, $log = '', $size = 3)  
$dir: 存放目录;  
$log：要记录的日志, 默认:空;  
$size：记录多少M后切换另一个文件，默认:3M;  
## 结束

## 事件监听 记录 sql 日志用法

1. 只要在 app\Providers\EventServiceProvider.php 配置 事件监听就可以了  
 ```
protected $listen = [
    // 新增SqlListener监听QueryExecuted
    'Illuminate\Database\Events\QueryExecuted' => [
        //
        'Large\Zhengdada\Listeners\SqlListener',
    ],
];
```
## 结束


## 搜索条件格式化 复用方法

1 . 控制器调用
```$xslt
use Large\Zhengdada\Search\Search;

public function goodsBrowseData(Request $request){

    list($limit , $where , $verify , $exclude) = Search::formatWehre($request);

```  
2 . 传入参数格式
```$xslt
$arr['parame']          // 要搜索的字段      
$arr['condition']       // 搜索字段条件格式   
$arr['excludeField']    // 不需要搜索的条件

$arr['parame'] = [
	'goods_name'	=>	'苹果',
	'price'         =>	'3999',
	'created_at'	=>	'2019-12-12 / 2019-12-29',
]
$arr['condition'] = [
	'goods_name'	=>	'%*%',
	'price'         =>	'>',
	'created_at'	=>	'between',
]
$arr['excludeField'] = [
	'created_at'	=>	'true'
]

或者下面格式

parame :{
    goods_name:'苹果'
    ,price:'3999'
    ,created_at:2019-12-12 / 2019-12-29
},
condition:{
    goods_name:'%*%'
    ,price:'>'
    ,created_at:'between'
},
excludeField:{
    created_at:true,
}
```
## 结束


MIT