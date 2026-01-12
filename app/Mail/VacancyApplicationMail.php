<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function build()
    {
        $vacancyLabel = match ($this->data['vacancy'] ?? '') {
            'coord' => 'Coordinadora',
            'manager' => 'Gerente',
            'submanager' => 'Subgerente',
            'credmanager' => 'Gestor de Crédito',
            default => 'Vacante',
        };

        return $this->subject("Nueva postulación: {$vacancyLabel}")
            ->view('emails.vacancy-application')
            ->with([
                'data' => $this->data,
                'vacancyLabel' => $vacancyLabel,
            ]);
    }
}
