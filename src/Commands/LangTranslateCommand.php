<?php

namespace Large\Zhengdada\Commands;


use Illuminate\Console\Command;
use Large\Zhengdada\Jobs\LangTranslateJob;

abstract class LangTranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LangTranslate {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '翻译中英文内容';


    /**
     * 返回一个时间，秒 大于30000秒
     * @return mixed
     */
    abstract protected function setTtl();

    /**
     * 判断当着是不是要运行任务
     * return false 不运行任务
     * @return mixed
     */
    abstract protected function verifyType();

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $lang = $this->argument('lang');

        if (!$this->verifyType()){
            $this->error('type: ' . 0 . $lang);
            // \Log::info(now() . 0 . $lang);
            return false;
        }

        if (!$lang) {
            \Cache::put('type', 0);
            \Cache::put('langTranslate', null);
            $this->error('lang: null');
            return false;
        }

        $data = \Cache::remember('langTranslate', $this->setTtl(), function () {

            return include(resource_path('lang/test/').'zh.php');
        });

        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                $data = \Cache::get('langTranslate');
                $this->info($data[$k]);
                unset($data[$k]);
                \Cache::put('langTranslate', $data);
                dispatch(new LangTranslateJob([$k => $v], $lang));
                break;
            }
        } else {
            \Cache::put('langTranslate', null);
            \Cache::put('type', 0);
        }

    }
}
