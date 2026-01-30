<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyCreditSellerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    // Estándar igual a los otros (Storage)
    public ?string $cvDisk;
    public ?string $cvPath;
    public ?string $cvName;

    public function __construct(array $data, ?string $cvDisk = null, ?string $cvPath = null, ?string $cvName = null)
    {
        $this->data = $data;
        $this->cvDisk = $cvDisk;
        $this->cvPath = $cvPath;
        $this->cvName = $cvName;
    }

    public function build()
    {
        $mail = $this->subject('Postulación: Vendedor de Crédito - ' . ($this->data['nombre'] ?? ''))
            ->view('emails.vacancies.creditseller', [
                'data' => $this->data,
            ]);

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
