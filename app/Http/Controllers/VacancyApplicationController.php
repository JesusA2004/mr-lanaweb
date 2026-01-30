<?php

namespace App\Http\Controllers;

use App\Mail\VacancyCoordinatorApplicationMail;
use App\Mail\VacancyManagerApplicationMail;
use App\Mail\VacancySubManagerApplicationMail;
use App\Mail\VacancyCreditSellerApplicationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VacancyApplicationController extends Controller {

    // Metodo para enviar postulación a Coordinadora
    public function submitCoordinator(Request $request) {
        $validated = array_merge(
            $this->validateBaseCommon($request),
            $request->validate([
                'p1_resguardo_efectivo' => ['required', 'in:si,no'],
                'p2_expedientes'        => ['required', 'in:si,no'],
                'p3_cuadres_cierre'     => ['required', 'in:si,no'],
                'p4_faltante'           => ['required', 'in:detengo_reporto,ajusto,dejo_despues'],
                'p5_responsabilidad'    => ['required', 'in:si,no'],
                // CV opcional para coordinadora:
                'cv'                    => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ], [
                'p1_resguardo_efectivo.required' => 'Selecciona una opción.',
                'p2_expedientes.required'        => 'Selecciona una opción.',
                'p3_cuadres_cierre.required'     => 'Selecciona una opción.',
                'p4_faltante.required'           => 'Selecciona una opción.',
                'p5_responsabilidad.required'    => 'Selecciona una opción.',
                'cv.mimes'                       => 'El CV debe ser un PDF.',
                'cv.max'                         => 'El CV no debe exceder 5MB.',
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancyCoordinatorApplicationMail($data, $disk, $path, $name)
        );
    }

    // Metodo para enviar postulación a Gerente
    public function submitManager(Request $request) {
        $validated = array_merge(
            $this->validateBaseManagerLike($request),
            $request->validate([
                'p1_cartera'      => ['required', 'in:si,no'],
                'p2_campo'        => ['required', 'in:si,no'],
                'p3_indicadores'  => ['required', 'in:si,no'],
                'p4_accion'       => ['required', 'in:analizo,reporteo,presiono'],
                'p5_presion'      => ['required', 'in:si,no'],
                // CV obligatorio para gerente:
                'cv'              => ['required', 'file', 'mimes:pdf', 'max:5120'],
            ], [
                'p1_cartera.required'     => 'Selecciona una opción.',
                'p2_campo.required'       => 'Selecciona una opción.',
                'p3_indicadores.required' => 'Selecciona una opción.',
                'p4_accion.required'      => 'Selecciona una opción.',
                'p5_presion.required'     => 'Selecciona una opción.',
                'cv.required'             => 'Adjunta tu CV en PDF (obligatorio).',
                'cv.mimes'                => 'El CV debe ser un PDF.',
                'cv.max'                  => 'El CV no debe exceder 5MB.',
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancyManagerApplicationMail($data, $disk, $path, $name)
        );
    }

    // Metodo para enviar postulación a Subgerente
    public function submitSubManager(Request $request) {
        $validated = array_merge(
            $this->validateBaseManagerLike($request),
            $request->validate([
                'p1_cartera'     => ['required', 'in:si,no'],
                'p2_campo'       => ['required', 'in:si,no'],
                'p3_indicadores' => ['required', 'in:si,no'],
                'p4_accion'      => ['required', 'in:analizo,reporteo,presiono'],
                'p5_presion'     => ['required', 'in:si,no'],
                // CV (ajusta si lo quieres obligatorio o no)
                'cv'             => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancySubManagerApplicationMail($data, $disk, $path, $name)
        );
    }

    // Metodo para enviar postulación a Vendedor de Crédito
    public function submitCreditSeller(Request $request)
    {
        $validated = array_merge(
            $this->validateBaseCreditSeller($request),
            $request->validate([
                'p1_ventas_cambaceo'    => ['required', 'in:si,no'],
                'p2_cobranza_campo'     => ['required', 'in:si,no'],
                'p3_moto_licencia'      => ['required', 'in:si,no'],
                'p4_trabajo_100_calle'  => ['required', 'in:si,no'],
                'p5_prioridad_credito'  => ['required', 'in:colocar_muchos,colocar_bien_cobrar,solo_vender'],
            ], [
                'p1_ventas_cambaceo.required'   => 'Selecciona una opción.',
                'p2_cobranza_campo.required'    => 'Selecciona una opción.',
                'p3_moto_licencia.required'     => 'Selecciona una opción.',
                'p4_trabajo_100_calle.required' => 'Selecciona una opción.',
                'p5_prioridad_credito.required' => 'Selecciona una opción.',
            ])
        );

        // Filtro (como ya lo traías)
        if (($validated['p1_ventas_cambaceo'] ?? null) === 'no') {
            return response()->json([
                'ok' => false,
                'message' => 'Para este puesto necesitamos experiencia REAL en ventas de campo/cambaceo.',
                'errors' => ['p1_ventas_cambaceo' => ['Este puesto requiere ventas de campo/cambaceo.']],
            ], 422);
        }

        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) =>
                new VacancyCreditSellerApplicationMail($data, $disk, $path, $name)
        );
    }

    // Base SOLO para Vendedor (sin experiencia_anios ni liderazgo)
    private function validateBaseCreditSeller(Request $request): array
    {
        return $request->validate(
            [
                'nombre'           => ['required', 'string', 'max:160'],
                'fecha_nacimiento' => ['required', 'date'],
                'telefono'         => ['required', 'regex:/^\d{10}$/'],
                'correo'           => ['required', 'email', 'max:160'],
                'sucursal'         => ['required', 'string', 'max:120'],
                'escolaridad'      => ['required', 'string', 'max:160'],
                'office'           => ['required', 'string', 'max:160'],
                'cv'               => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ],
            [
                'telefono.regex' => 'El teléfono debe tener 10 dígitos.',
                'cv.mimes'       => 'El CV debe ser un PDF.',
                'cv.max'         => 'El CV no debe exceder 5MB.',
            ]
        );
    }

    // Base común para todas las vacantes
    private function validateBaseCommon(Request $request): array {
        return $request->validate(
            [
                'nombre'          => ['required', 'string', 'max:160'],
                'fecha_nacimiento'=> ['required', 'date'],
                'telefono'        => ['required', 'regex:/^\d{10}$/'],
                'correo'          => ['required', 'email', 'max:160'],
                'sucursal'        => ['required', 'string', 'max:120'],
                'escolaridad'     => ['required', 'string', 'max:160'],
                'office'          => ['required', 'string', 'max:160'],
            ],
            [
                'telefono.regex'  => 'El teléfono debe tener 10 dígitos.',
            ]
        );
    }

    // Base para Gerente/Subgerente
    private function validateBaseManagerLike(Request $request): array {
        return $request->validate(
            [
                // common
                'nombre'           => ['required', 'string', 'max:160'],
                'fecha_nacimiento' => ['required', 'date'],
                'telefono'         => ['required', 'regex:/^\d{10}$/'],
                'correo'           => ['required', 'email', 'max:160'],
                'sucursal'         => ['required', 'string', 'max:120'],
                'escolaridad'      => ['required', 'string', 'max:160'],
                'office'           => ['required', 'string', 'max:160'],

                // manager-like
                'experiencia_anios'=> ['required', 'string', 'max:30'],
                'liderazgo'        => ['required', 'in:si,no'],
            ],
            [
                'telefono.regex' => 'El teléfono debe tener 10 dígitos.',
            ]
        );
    }

    // Obtener destinatario de vacantes desde configuración
    private function vacanciesRecipient(): array {
        $address = config('mail.recipients.vacancies.address') ?: config('mail.from.address');
        $name    = config('mail.recipients.vacancies.name') ?: config('mail.from.name');
        if (!$address || !filter_var($address, FILTER_VALIDATE_EMAIL)) {
            abort(response()->json([
                'ok' => false,
                'message' => 'Destinatario de vacantes inválido. Revisa VACANCIES_TO_ADDRESS (o MAIL_FROM_ADDRESS).',
                'debug' => app()->isLocal() ? compact('address', 'name') : null,
            ], 500));
        }
        return [$address, $name];
    }

    // Envío de correo con CV adjunto (si aplica) y limpieza de archivo temporal
    private function sendWithCv(Request $request, array $validated, \Closure $mailableFactory) {
        [$toAddress, $toName] = $this->vacanciesRecipient();
        $disk = 'local';
        $tempPath = null;
        $attachName = null;
        $hasCv = false;

        try {
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $folder = 'tmp/cv/' . now()->format('Ymd') . '/' . Str::uuid()->toString();

                $attachName = 'CV_' . Str::slug($validated['nombre']) . '_' . now()->format('His') . '.pdf';
                $tempPath = $file->storeAs($folder, $attachName, $disk);

                $hasCv = true;
            }

            // 🔥 AGREGA ESTO (contrato explícito con el Blade)
            $validated['has_cv']  = $hasCv;
            $validated['cv_name'] = $attachName;
            $validated['cv_path'] = $tempPath;

            $mailable = $mailableFactory($validated, $disk, $tempPath, $attachName);

            Mail::to($toAddress, $toName)->send($mailable);

            return response()->json([
                'ok' => true,
                'message' => 'Listo. La postulación se envió correctamente.',
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo enviar tu postulación en este momento.',
                'debug' => app()->isLocal() ? $e->getMessage() : null,
            ], 500);

        } finally {
            if ($tempPath && Storage::disk($disk)->exists($tempPath)) {
                Storage::disk($disk)->delete($tempPath);
                Storage::disk($disk)->deleteDirectory(dirname($tempPath));
            }
        }
    }

}
