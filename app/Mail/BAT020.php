<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BAT020 extends Mailable
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
            ->subject('【shahaaan!! 管理】マスタ連携エラー')
            ->text('emails.text.bat020', [
                'startTime' => $this->paramsMail['startTime'] ?? null,
                'endTime' => $this->paramsMail['endTime'] ?? null,
                'errorLogOfMst' => $this->paramsMail['errorLogOfMst'] ?? null,
                'errorLog' => $this->paramsMail['errorLog'] ?? null,
            ]);
    }
}
