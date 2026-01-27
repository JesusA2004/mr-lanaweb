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

    public function submitCoordinator(Request $request) {
        $validated = array_merge(
            $this->validateBase($request),
            $request->validate([
                'p1_resguardo_efectivo' => ['required', 'in:si,no'],
                'p2_expedientes'        => ['required', 'in:si,no'],
                'p3_cuadres_cierre'     => ['required', 'in:si,no'],
                'p4_faltante_accion'    => ['required', 'in:detengo_reporto,ajusto_cuadro,dejo_manana'],
                'p5_responsabilidad'    => ['required', 'in:si,no'],
            ], [
                'p1_resguardo_efectivo.required' => 'Selecciona una opción.',
                'p2_expedientes.required'        => 'Selecciona una opción.',
                'p3_cuadres_cierre.required'     => 'Selecciona una opción.',
                'p4_faltante_accion.required'    => 'Selecciona una opción.',
                'p5_responsabilidad.required'    => 'Selecciona una opción.',
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancyCoordinatorApplicationMail($data, $disk, $path, $name)
        );
    }

    public function submitManager(Request $request) {
        $validated = array_merge(
            $this->validateBase($request),
            $request->validate([
                'p1_cartera' => ['required', 'in:si,no'],
                'p2_campo' => ['required', 'in:si,no'],
                'p3_indicadores' => ['required', 'in:si,no'],
                'p4_accion' => ['required', 'in:analizo,reporteo,presiono'],
                'p5_presion' => ['required', 'in:si,no'],
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancyManagerApplicationMail($data, $disk, $path, $name)
        );
    }

    public function submitSubManager(Request $request) {
        $validated = array_merge(
            $this->validateBase($request),
            $request->validate([
                'p1_cartera' => ['required', 'in:si,no'],
                'p2_campo' => ['required', 'in:si,no'],
                'p3_indicadores' => ['required', 'in:si,no'],
                'p4_accion' => ['required', 'in:analizo,reporteo,presiono'],
                'p5_presion' => ['required', 'in:si,no'],
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancySubManagerApplicationMail($data, $disk, $path, $name)
        );
    }

    public function submitCreditSeller(Request $request) {
        $validated = array_merge(
            $this->validateBase($request),
            $request->validate([
                'p_experiencia_ventas' => ['nullable', 'in:si,no'],
                'p_cobranza' => ['nullable', 'in:si,no'],
                'p_meta_diaria' => ['nullable', 'in:si,no'],
            ])
        );
        return $this->sendWithCv(
            $request,
            $validated,
            fn (array $data, ?string $disk, ?string $path, ?string $name) => new VacancyCreditSellerApplicationMail($data, $disk, $path, $name)
        );
    }

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

    private function validateBase(Request $request): array {
        return $request->validate(
            [
                'nombre' => ['required', 'string', 'max:160'],
                'fecha_nacimiento' => ['required', 'date'],
                'telefono' => ['required', 'regex:/^\d{10}$/'],
                'correo' => ['required', 'email', 'max:160'],
                'sucursal' => ['required', 'string', 'max:120'],
                'escolaridad' => ['required', 'string', 'max:160'],
                'office' => ['required', 'string', 'max:160'],
                'experiencia_anios' => ['required', 'string', 'max:30'],
                'liderazgo' => ['required', 'in:si,no'],
                'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ],
            [
                'telefono.regex' => 'El teléfono debe tener 10 dígitos.',
                'cv.mimes' => 'El CV debe ser un PDF.',
                'cv.max' => 'El CV no debe exceder 5MB.',
            ]
        );
    }

    private function sendWithCv(Request $request, array $validated, \Closure $mailableFactory) {
        [$toAddress, $toName] = $this->vacanciesRecipient();
        $disk = 'local';
        $tempPath = null;
        $attachName = null;
        try {
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');

                $folder = 'tmp/cv/' . now()->format('Ymd') . '/' . Str::uuid()->toString();
                $attachName = 'CV_' . Str::slug($validated['nombre']) . '_' . now()->format('His') . '.pdf';
                $tempPath = $file->storeAs($folder, $attachName, $disk);
            }

            $mailable = $mailableFactory($validated, $disk, $tempPath, $attachName);
            Mail::to($toAddress, $toName)->send($mailable);
            return response()->json([
                'ok' => true,
                'message' => 'Listo. La postulación se envió correctamente.',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo enviar tu postulación en este momento. Intenta nuevamente.',
                'debug' => app()->isLocal() ? $e->getMessage() : null,
            ], 500);
        } finally {
            if ($tempPath && Storage::disk($disk)->exists($tempPath)) {
                Storage::disk($disk)->delete($tempPath);

                $dir = dirname($tempPath);
                if (
                    count(Storage::disk($disk)->files($dir)) === 0 &&
                    count(Storage::disk($disk)->directories($dir)) === 0
                ) {
                    Storage::disk($disk)->deleteDirectory($dir);
                }
            }
        }
    }
    
}
