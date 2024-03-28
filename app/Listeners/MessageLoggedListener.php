<?php

namespace App\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Symfony\Component\Console\Output\ConsoleOutput;

class MessageLoggedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\MessageLogged $event
     * @return void
     */
    public function handle(MessageLogged $event) {
        if (app()->runningInConsole()) {
            $logLevelsOrder = [
                'debug',
                'info',
                'notice',
                'warning',
                'error',
                'critical',
                'alert',
                'emergency',
            ];
            $envLevel = env('LOG_LEVEL', 'debug');
            $envLevelOrder = 0;
            $eventLevelOrder = 0;
            foreach ($logLevelsOrder as $order => $level) {
                if ($level === $envLevel) {
                    $envLevelOrder = $order;
                }
                if ($level === $event->level) {
                    $eventLevelOrder = $order;
                }
            }
            if ($eventLevelOrder < $envLevelOrder) {
                return;
            }
            $output = new ConsoleOutput();
            switch ($event->level) {
                case 'info':
                    $output->writeln("<info>{$event->message}</info>");
                    break;
                case 'error':
                    $output->writeln("<error>{$event->message}</error>");
                    break;
                default:
                    $output->writeln("{$event->message}");
            }
        }
    }
}
