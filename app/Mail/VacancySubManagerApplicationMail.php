<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancySubManagerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
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
        $mail = $this->subject('Postulación: Subgerente - ' . ($this->data['nombre'] ?? ''))
            ->view('emails.vacancies.submanager', [
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
