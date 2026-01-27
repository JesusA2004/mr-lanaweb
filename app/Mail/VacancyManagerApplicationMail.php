<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyManagerApplicationMail extends Mailable {

    use Queueable, SerializesModels;

    public array $data;

    // Para adjuntar desde Storage (privado)
    public ?string $cvDisk;
    public ?string $cvPath;
    public ?string $cvName;

    public function __construct(array $data, ?string $cvDisk = null, ?string $cvPath = null, ?string $cvName = null) {
        $this->data = $data;
        $this->cvDisk = $cvDisk;
        $this->cvPath = $cvPath;
        $this->cvName = $cvName;
    }

    public function build() {
        $mail = $this->subject('Postulación: Gerente - ' . ($this->data['nombre'] ?? ''))
            ->view('emails.vacancies.manager', [
                'data' => $this->data, // para el blade
            ]);
        // Adjunta SI existe en storage (sin rutas absolutas)
        if ($this->cvDisk && $this->cvPath) {
            $mail->attachFromStorageDisk(
                $this->cvDisk,
                $this->cvPath,
                $this->cvName ?: 'CV.pdf',
                ['mime' => 'application/pdf']
            );
        }
        return $mail;
    }

}
