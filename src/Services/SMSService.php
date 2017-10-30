<?php

namespace LaravelAdmin\Services;


use Flc\Alidayu\App;
use Flc\Alidayu\Client;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class SMSService{
    protected $client;
    protected $smsSend;

    public function __construct()
    {
        $this->client = new Client(new App([
            'app_key'=>config('sms.ali_dayu.app_key'),
            'app_secret'=>config('sms.ali_dayu.app_secret')
        ]));
        $this->smsSend = new AlibabaAliqinFcSmsNumSend();
    }

    /**
     * 短信发送
     * @return false|object
     */
    public function send(){
        return $this->client->execute($this->smsSend);
    }

    public function __call($name, $arguments)
    {
        call_user_func_array(array($this->smsSend,$name),$arguments);
        return $this;
    }


}