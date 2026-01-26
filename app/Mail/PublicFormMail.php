<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublicFormMail extends Mailable {

    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function build() {
        $map = [
            'impulsat' => 'Solicitud - Impulsa.t',
            'impulsa_negocio' => 'Solicitud - Impulsa tu negocio',
            'credito_comadres' => 'Solicitud - Crédito Comadres',
        ];

        $subject = $map[$this->data['context']] ?? 'Solicitud web';

        return $this->subject($subject)
            ->replyTo($this->data['email'], trim(($this->data['nombres'] ?? '').' '.($this->data['apellido1'] ?? '')))
            ->view('emails.public-form')
            ->with(['d' => $this->data]);
    }

}
