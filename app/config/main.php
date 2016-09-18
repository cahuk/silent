<?php

return [
    'viewPath' => APP_PATH . 'views',
    'layoutPath' => APP_PATH . 'views' . DIRECTORY_SEPARATOR . 'layouts',
    'components' => [
        'request' => '\\silent\\app\components\\SymfonyFoundationRequest',
        'response' => '\\silent\\app\components\\SymfonyFoundationResponse',
    ]
];