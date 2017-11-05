<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            //新浪微博三方登录
            'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
            //QQ三方登录
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
            //微信三方登录
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
