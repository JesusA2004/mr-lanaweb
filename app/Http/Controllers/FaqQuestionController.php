<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FaqQuestionMail;

class FaqQuestionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'   => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:190'],
            'pregunta' => ['required', 'string', 'max:1500'],
        ]);

        // Destino (configurable en .env) -> CONTACT_TO_ADDRESS / CONTACT_TO_NAME
        $toAddress = config('mail.recipients.contact.address') ?: config('mail.from.address');
        $toName    = config('mail.recipients.contact.name') ?: config('mail.from.name');

        if (!$toAddress || !filter_var($toAddress, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'ok' => false,
                'message' => 'Destinatario inválido. Revisa CONTACT_TO_ADDRESS (o MAIL_FROM_ADDRESS).',
                'debug' => app()->isLocal() ? compact('toAddress', 'toName') : null,
            ], 500);
        }

        try {
            // FIX: NO pasar associative array a Mail::to()
            Mail::to($toAddress, $toName)->send(new FaqQuestionMail($data));

            return response()->json([
                'ok' => true,
                'message' => 'Tu pregunta fue enviada correctamente.',
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo enviar tu pregunta en este momento.',
                'debug' => app()->isLocal() ? $e->getMessage() : null,
            ], 500);
        }
    }
}
