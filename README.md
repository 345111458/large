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

    list($where, $verify, $exclude, $page, $limit) = Search::formatWehre($request);
    $where      // 要查询的条件
    $verify,    // 如果为true就用上面的条件查询
    $exclude,   // 过滤字段，自己处理
    $page,      // 当前页面
    $limit      // 查询多少条数据
    
    #### 返回一个数组 ，5个参数，如下格式
    Array
    (
        [0] => Array
            (
                [0] => Array
                    (
                        [0] => goods_name
                        [1] => LIKE
                        [2] => %苹果%
                    )
                [1] => Array
                    (
                        [0] => price
                        [1] => >
                        [2] => 3999
                    )
            )
        [1] => 1
        [2] => Array
            (
                [created_at] => 2019-12-12 / 2019-12-29
            )
        [3] => 1
        [4] => 10
    )
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



## 新增百度翻译 方法

1 . 发布配置文件----如果是laravel框架可以执行这一步，其它框架不用

```
php artisan vendor:publish --provider="Large\Zhengdada\ServiceProvider\BaiduTranslateServiceProvider"  

.env 文件添加配置参数
BAIDU_APPID=2019050xxxxxxxxxx
BAIDU_KEY=urzK81jxxxxxxxxxxxx

```

2 . 调用方法
```
laravel 框架调用方式
翻译英文
echo app('baidu')->translate('魂牵梦萦' , '-');
返回格式： Haunted-by-dreams

翻译拼音
echo app('baidu')->pinyin('魂牵梦萦' , '-');
返回格式： qian-hun-men-yin



其它框架调用方式
use Large\Zhengdada\BaiduTranslate\BaiduTranslate;
$res = new BaiduTranslate(['appid'=>'xxxxx','key'=>'xxxxxx']);
$res->translate('魂牵梦萦','-');
返回格式： Haunted-by-dreams

翻译拼音
echo $res->pinyin('魂牵梦萦' , '-');
返回格式： qian-hun-men-yin


```


## 结束



MIT