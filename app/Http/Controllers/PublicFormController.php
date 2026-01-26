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
            // comunes / condicionales
            'negocioFisico' => ['nullable', 'in:Si,No'],
            'giroNegocio' => ['nullable', 'string', 'max:190'],
            'empleoCuenta' => ['nullable', 'in:,Formal,Informal'],
            'tipoEmpleo' => ['nullable', 'string', 'max:190'],
        ]);

        // Reglas por modal (context)
        if ($data['context'] === 'impulsa_negocio') {
            // negocioFisico requerido aquí
            if (empty($data['negocioFisico'])) {
                return response()->json(['message' => 'Falta negocioFisico'], 422);
            }
            if (($data['negocioFisico'] ?? '') === 'Si' && empty(trim($data['giroNegocio'] ?? ''))) {
                return response()->json(['message' => 'Falta giroNegocio'], 422);
            }
        }
        if ($data['context'] === 'impulsat') {
            if (empty($data['empleoCuenta'])) return response()->json(['message' => 'Falta empleoCuenta'], 422);
            if (empty(trim($data['tipoEmpleo'] ?? ''))) return response()->json(['message' => 'Falta tipoEmpleo'], 422);
        }
        if ($data['context'] === 'credito_comadres') {
            // si Crédito Comadres no usa esos campos, no pasa nada: van vacíos
            // aquí puedes meter reglas extra si luego agregas “grupo”, etc.
        }
        Mail::to(config('mail.to.address'))->send(new PublicFormMail($data));
        return response()->json(['ok' => true]);
    }
    
}
