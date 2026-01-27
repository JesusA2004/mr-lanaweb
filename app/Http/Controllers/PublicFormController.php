<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublicFormMail;

class PublicFormController extends Controller {
    
    public function store(Request $request) {
        $data = $request->validate([
            'context' => ['required', 'string', 'in:impulsat,impulsa_negocio,credito_comadres'],
            'branch' => ['required', 'string', 'max:120'],
            'nombres' => ['required', 'string', 'max:120'],
            'apellido1' => ['required', 'string', 'max:120'],
            'apellido2' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'telefono' => ['required', 'string', 'max:40'],
            'direccion' => ['required', 'string', 'max:190'],

            'negocioFisico' => ['nullable', 'in:Si,No'],
            'giroNegocio' => ['nullable', 'string', 'max:190'],
            'empleoCuenta' => ['nullable', 'in:Formal,Informal'],
            'tipoEmpleo' => ['nullable', 'string', 'max:190'],
        ]);
        // Reglas por modal (context)
        if ($data['context'] === 'impulsa_negocio') {
            if (empty($data['negocioFisico'])) {
                return response()->json(['message' => 'Falta negocioFisico'], 422);
            }

            if (($data['negocioFisico'] ?? '') === 'Si' && empty(trim($data['giroNegocio'] ?? ''))) {
                return response()->json(['message' => 'Falta giroNegocio'], 422);
            }
        }
        if ($data['context'] === 'impulsat') {
            if (empty($data['empleoCuenta'])) {
                return response()->json(['message' => 'Falta empleoCuenta'], 422);
            }

            if (empty(trim($data['tipoEmpleo'] ?? ''))) {
                return response()->json(['message' => 'Falta tipoEmpleo'], 422);
            }
        }
        $toAddress = config('mail.recipients.contact.address');
        $toName    = config('mail.recipients.contact.name');
        if (!filter_var($toAddress, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'CONTACT_TO_ADDRESS inválido. Revisa .env',
                'debug' => app()->isLocal() ? compact('toAddress', 'toName') : null,
            ], 500);
        }
        try {
            // AQUÍ está el fix: NO pasar associative array
            Mail::to($toAddress, $toName)->send(new PublicFormMail($data));
            return response()->json(['message' => 'Solicitud enviada correctamente'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'No se pudo enviar el correo',
                'error' => app()->isLocal() ? $e->getMessage() : null,
            ], 500);
        }
    }

}
