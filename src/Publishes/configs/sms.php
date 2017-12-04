<?php

return [
    'ali_dayu' => [
        'app_key' => env('ALI_DAYU_APP_KEY',''), //APP KEY
        'app_secret' => env('ALI_DAYU_APP_SECRET',''), //APP SECRET
        'signature'=>menv('ALI_DAYU_SIGNATURE',''), //短信签名:可以使用网站名称
        'template_codes'=>[ //模板代码
            'register'=>env('ALI_DAYU_CODE_REGISTER',''), //用户注册短信模板
            'login'=>env('ALI_DAYU_CODE_LOGIN',''), //用户注册短信模板
            'forgot'=>env('ALI_DAYU_CODE_FORGOT',''), //用户注册短信模板
        ]
    ]

];
