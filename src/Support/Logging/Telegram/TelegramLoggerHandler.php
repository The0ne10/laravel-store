<?php

namespace App\Logging\Telegram;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Services\Telegram\TelegramBotApi;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;
    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        $this->chatId = (int) $config['chat_id'];
        $this->token = $config['token'];
        parent::__construct($level);
    }

    protected function write(LogRecord $record): void
    {
        // $record->formatted
        TelegramBotApi::sendMessage(
            $this->token,
            $this->chatId,
            $record->formatted);
    }
}