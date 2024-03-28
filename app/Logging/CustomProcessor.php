<?php

namespace App\Logging;

use Monolog\Processor\ProcessorInterface;

class CustomProcessor implements ProcessorInterface
{
    public function __invoke(array $record) {
        $record['extra']['session_id'] = session()->getId() ?? '-';
        $record['extra']['user_id'] = auth()->id() ?? '-';

        return $record;
    }
}
