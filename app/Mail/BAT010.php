<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BAT010 extends Mailable
{
    use Queueable;
    use SerializesModels;

    public array $paramsMail;

    /**
     * Create a new message instance.
     *
     * @param array $paramsMail
     * @return void
     */
    public function __construct(array $paramsMail) {
        $this->paramsMail = $paramsMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->subject('【shahaaan!! 管理】注文CSVアップロードエラー')
            ->text('emails.text.bat010', [
                'startTime' => $this->paramsMail['start_time'] ?? null,
                'endTime' => $this->paramsMail['end_time'] ?? null,
                'result1' => $this->paramsMail['result1'] ?? null,
                'result2' => $this->paramsMail['result2'] ?? null,
            ]);
    }
}
