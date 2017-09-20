<?php

namespace LaravelAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LaravelAdmimPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-admin:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //极验验证发布
        Artisan::call('vendor:publish', [
            '--tag' => 'geetest'
        ]);

        //语言包发布
        Artisan::call('lang:publish', ['zh-CN,zh-HK,th,tk']);

        //发布资源包
        Artisan::call('vendor:publish', [
            '--tag' => 'resource'
        ]);

        //发布城市表
        Artisan::call('vendor:publish', [
            '--tag' => 'resource-example'
        ]);

        //发布LaravelAdmin
        Artisan::call('vendor:publish', [
            '--tag' => 'laravel-admin',
            '--force' => true
        ]);
    }
}
