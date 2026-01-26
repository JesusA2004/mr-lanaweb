<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublicFormMail extends Mailable {

    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function build(){
        $context = $this->data['context'] ?? 'impulsat';
        $view = match ($context) {
            'impulsa_negocio' => 'emails.impulsa_negocio',
            'credito_comadres' => 'emails.credito_comadres',
            default => 'emails.impulsat',
        };
        return $this
            ->subject('Nueva solicitud · Mr. Lana')
            ->view($view)
            ->with(['d' => $this->data]);
    }

}
