<h1 align="center"> zhengdada </h1>

<p align="center"> 常用工具包.</p>


## Installing

```shell
$ composer require large/zhengdada -vvv
```

## Usage

TODO

## Contributing
这一行是测试，在来一次

创建目录用法
1. use Large\Zhengdada\Directory\Directory;
2. Directory::mkdirs($dir = '' , $chmod = 0755)  
$dir：要创建的目录;  
$chmod：文件权限 默认:0755;  

## License


## Contributing

自定义 记录日志 方法
1. use Large\Zhengdada\LargeLog;
2. Logs::mkLogFile($dir, $log = '', $size = 3)  
$dir: 存放目录;  
$log：要记录的日志, 默认:空;  
$size：记录多少M后切换另一个文件，默认:3M;  

## License

## Contributing 

记录 sql 日志用法 。 

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
## License

MIT