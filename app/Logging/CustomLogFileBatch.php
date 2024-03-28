<?php

namespace App\Logging;

use Arr;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\WebProcessor;

class CustomLogFileBatch
{
    public const FORMAT = "[%datetime%] %level_name%: %message% %context%\n";

    public function __invoke($logger) {
        $webProcessor = new WebProcessor();
        $customProcessor = new CustomProcessor();
        $lineFormatter = new LineFormatter(static::FORMAT, 'Y-m-d H:i:s', true, true);
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor($webProcessor);
            $batchId = explode(':', Arr::get(request()->server('argv'), '1'))[1];
            $handler->setFilenameFormat("{$batchId}" . '_{date}', 'Ymd');
            $handler->pushProcessor($customProcessor);
            $handler->setFormatter($lineFormatter);
        }
    }
}
