<?php
/**
 * 這裡存放各通訊軟體推播/機器人所需參數
 */
return [
    ## Telegram
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'api_url' => env('TELEGRAM_API_URL'),
    ],
];
