<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $base = [
            'vacancy' => ['required', Rule::in(['coord','manager','submanager','credmanager'])],
            'nombre' => ['required','string','max:120'],
            'fecha_nacimiento' => ['required','date'],
            'telefono' => ['required','string','regex:/^[0-9]{10}$/'],
            'correo' => ['required','email','max:150'],
            'sucursal' => ['required','string','max:60'],
            'escolaridad' => ['required','string','max:120'],
        ];

        $coord = [
            'office_nivel' => ['required','string','max:60'],
            'manejo_efectivo' => ['required', Rule::in(['Si','No'])],
            'monto_maximo' => ['required','numeric','min:0'],
            'cortes_arqueos' => ['required', Rule::in(['Si','No'])],
        ];

        $mgr = [
            'moto' => ['required', Rule::in(['Si','No'])],
            'licencia' => ['required', Rule::in(['Si','No'])],
            'personal' => ['required', Rule::in(['Si','No'])],
            'indicadores' => ['required', Rule::in(['Si','No'])],
            'cobranza' => ['required', Rule::in(['Si','No'])],
        ];

        $cred = [
            'moto' => ['required', Rule::in(['Si','No'])],
            'moto_anios' => ['required','integer','min:0','max:50'],
            'licencia' => ['required', Rule::in(['Si','No'])],
            'ventas' => ['required', Rule::in(['Si','No'])],
            'atencion_cliente' => ['required', Rule::in(['Si','No'])],
        ];

        $vacancy = $this->input('vacancy');

        if ($vacancy === 'coord') return array_merge($base, $coord);
        if (in_array($vacancy, ['manager','submanager'], true)) return array_merge($base, $mgr);
        if ($vacancy === 'credmanager') return array_merge($base, $cred);

        return $base;
    }

    public function messages(): array
    {
        return [
            'telefono.regex' => 'El teléfono debe tener 10 dígitos.',
        ];
    }
}
