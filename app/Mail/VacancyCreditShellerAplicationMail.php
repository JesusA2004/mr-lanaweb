<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyCreditSellerApplicationMail extends Mailable {

    use Queueable, SerializesModels;

    public array $data;
    public ?string $cvAbsolutePath;
    public ?string $cvName;

    public function __construct(array $data, ?string $cvAbsolutePath = null, ?string $cvName = null) {
        $this->data = $data;
        $this->cvAbsolutePath = $cvAbsolutePath;
        $this->cvName = $cvName;
    }

    public function build() {
        $mail = $this->subject('Postulación: Vendedor de Crédito - ' . ($this->data['nombre'] ?? ''))
            ->view('emails.vacancies.creditseller');
        if ($this->cvAbsolutePath && is_file($this->cvAbsolutePath)) {
            $mail->attach($this->cvAbsolutePath, ['as' => $this->cvName ?: 'CV.pdf', 'mime' => 'application/pdf']);
        }
        return $mail;
    }

}
