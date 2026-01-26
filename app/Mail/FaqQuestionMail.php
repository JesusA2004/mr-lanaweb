<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FaqQuestionMail extends Mailable {

    use Queueable, SerializesModels;

    public array $d;

    public function __construct(array $data) {
        $this->d = $data;
    }

    public function build() {
        return $this->subject('Nueva pregunta desde FAQs')
            ->view('emails.faq_question')
            ->with(['d' => $this->d]);
    }

}
