<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Postulación: Gerente</title>
</head>

<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
@php
  // Helpers simples (evitan "No" cuando viene vacío)
  $val = fn($k, $d='') => trim((string) data_get($data ?? [], $k, $d));
  $yn  = function($k){
    $v = strtolower(trim((string) data_get($GLOBALS['data'] ?? [], $k, '')));
    if ($v === 'si') return 'Sí';
    if ($v === 'no') return 'No';
    return '—';
  };
  $fmtDate = function($s){
    $s = trim((string)$s);
    if (!$s) return '—';
    // si viene YYYY-MM-DD, lo dejamos tal cual (reclutamiento lo entiende)
    return $s;
  };

  $accion = strtolower($val('p4_accion'));
  $accionTxt = match ($accion) {
    'analizo'  => 'Analiza indicadores y corrige con el equipo',
    'reporteo' => 'Reporta y espera indicaciones',
    'presiono' => 'Presiona sin cambiar estrategia',
    default    => '—',
  };
@endphp

  <div style="max-width:720px;margin:0 auto;padding:24px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">

      <!-- HEADER -->
      <div style="padding:18px 20px;background:#0b67a3;color:#fff;">
        <div style="font-size:14px;opacity:.92;">Mr Lana · Reclutamiento</div>
        <div style="font-size:20px;font-weight:800;margin-top:4px;line-height:1.2;">
          Postulación: Gerente
        </div>
        <div style="font-size:12px;opacity:.9;margin-top:6px;">
          Registro recibido: {{ now()->format('Y-m-d H:i:s') }}
        </div>
      </div>

      <!-- BODY -->
      <div style="padding:20px;">
        <!-- BLOQUE: DATOS -->
        <h3 style="margin:0 0 10px 0;font-size:16px;">Datos del candidato</h3>

        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr>
            <td style="padding:8px 0;color:#6b7280;width:220px;">Nombre</td>
            <td style="padding:8px 0;font-weight:700;">{{ e($val('nombre','—')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Fecha de nacimiento</td>
            <td style="padding:8px 0;">{{ e($fmtDate($val('fecha_nacimiento'))) }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Teléfono</td>
            <td style="padding:8px 0;">{{ e($val('telefono')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Correo</td>
            <td style="padding:8px 0;">
              @php($correo = $val('correo'))
              @if($correo)
                <a href="mailto:{{ e($correo) }}" style="color:#0b67a3;text-decoration:none;font-weight:700;">
                  {{ e($correo) }}
                </a>
              @else
                —
              @endif
            </td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Sucursal</td>
            <td style="padding:8px 0;">{{ e($val('sucursal')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Escolaridad</td>
            <td style="padding:8px 0;">{{ e($val('escolaridad')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Paquetería Office</td>
            <td style="padding:8px 0;">{{ e($val('office')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Años de experiencia</td>
            <td style="padding:8px 0;">{{ e($val('experiencia_anios')) ?: '—' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">¿Liderazgo?</td>
            <td style="padding:8px 0;">{{ $yn('liderazgo') }}</td>
          </tr>
        </table>

        <hr style="border:none;border-top:1px solid #e5e7eb;margin:18px 0;">

        <!-- BLOQUE: CUESTIONARIO -->
        <h3 style="margin:0 0 10px 0;font-size:16px;">Cuestionario</h3>

        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr>
            <td style="padding:8px 0;color:#6b7280;width:220px;">Cartera de crédito</td>
            <td style="padding:8px 0;">{{ $yn('p1_cartera') }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Equipos de campo</td>
            <td style="padding:8px 0;">{{ $yn('p2_campo') }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Indicadores</td>
            <td style="padding:8px 0;">{{ $yn('p3_indicadores') }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Acción ante incumplimiento</td>
            <td style="padding:8px 0;">{{ e($accionTxt) }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Comodidad con presión</td>
            <td style="padding:8px 0;">{{ $yn('p5_presion') }}</td>
          </tr>
        </table>

        <!-- NOTA CV -->
        <div style="margin-top:16px;padding:12px 14px;border:1px solid #e5e7eb;border-radius:12px;background:#f9fafb;font-size:13px;color:#374151;">
          <div style="font-weight:800;margin-bottom:4px;">CV</div>
          Si el candidato adjuntó archivo, llega como PDF adjunto en este correo.
        </div>

        <!-- FOOTER -->
        <div style="margin-top:18px;font-size:12px;color:#6b7280;">
          Este correo fue generado automáticamente desde el formulario de Vacantes (Gerente).
        </div>
      </div>
    </div>
  </div>
</body>
</html>
