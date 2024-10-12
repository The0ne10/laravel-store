<?php

namespace App\Logging\Telegram;

use Monolog\Logger;

class TelegramLoggerHandler
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('telegram');
        

        return $logger;

    }
}
