<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'modules' => [
        'social' => [
            'class' => 'kartik\social\Module',
            'disqus' => [
                'settings' => ['shortname' => 'DISQUS_SHORTNAME']
            ],
            'facebook' => [
                'appId' => '205382639884285',
                'secret' => 'e2e92ac7cc6621294f945e4002f2e02a'
            ],
            'google' => [
                'clientId' => 'GOOGLE_API_CLIENT_ID',
                'pageId' => 'GOOGLE_PLUS_PAGE_ID',
                'profileId' => 'GOOGLE_PLUS_PROFILE_ID',
            ],
            'googleAnalytics' => [
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN'
            ],
            'twitter' => [
                'screenName' => 'TWITTER_SCREEN_NAME'
            ]
        ]
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
