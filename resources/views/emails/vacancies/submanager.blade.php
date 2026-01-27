<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Postulación: Subgerente</title>
</head>

<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
@php
  $val = function(string $k, string $d='') use ($data) {
    return trim((string) data_get($data ?? [], $k, $d));
  };

  $yn = function(string $k) use ($data) {
    $v = strtolower(trim((string) data_get($data ?? [], $k, '')));
    return $v === 'si' ? 'Sí' : ($v === 'no' ? 'No' : '—');
  };

  $fmtDate = function($s) {
    $s = trim((string) $s);
    return $s ?: '—';
  };

  $accion = strtolower($val('p4_accion'));
  $accionTxt = match ($accion) {
    'analizo'  => 'Analiza indicadores y corrige con el equipo',
    'reporteo' => 'Reporta y espera indicaciones',
    'presiono' => 'Presiona sin cambiar estrategia',
    default    => '—',
  };

  $qa = [
    ['q' => '¿Has sido responsable directo del resultado de una cartera de crédito (colocación y cobranza)?', 'a' => $yn('p1_cartera')],
    ['q' => '¿Has liderado equipos comerciales de campo con metas mensuales?', 'a' => $yn('p2_campo')],
    ['q' => '¿Has trabajado con indicadores como mora, colocación, recuperación y productividad por asesor?', 'a' => $yn('p3_indicadores')],
    ['q' => 'Cuando una sucursal no cumple metas de colocación o cobranza, tú normalmente…', 'a' => $accionTxt],
    ['q' => 'Este puesto implica presión por resultados, supervisión en campo y decisiones difíciles. ¿Te sientes cómodo(a)?', 'a' => $yn('p5_presion')],
  ];
@endphp

  <div style="max-width:720px;margin:0 auto;padding:24px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">

      <div style="padding:18px 20px;background:#0b67a3;color:#fff;">
        <div style="font-size:14px;opacity:.92;">Mr Lana · Reclutamiento</div>
        <div style="font-size:20px;font-weight:800;margin-top:4px;line-height:1.2;">
          Postulación: Subgerente
        </div>
        <div style="font-size:12px;opacity:.9;margin-top:6px;">
          Registro recibido: {{ now()->format('Y-m-d H:i:s') }}
        </div>
      </div>

      <div style="padding:20px;">
        <h3 style="margin:0 0 10px 0;font-size:16px;">Datos del candidato</h3>

        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6b7280;width:220px;">Nombre</td><td style="padding:8px 0;font-weight:700;">{{ e($val('nombre','—')) ?: '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Fecha de nacimiento</td><td style="padding:8px 0;">{{ e($fmtDate($val('fecha_nacimiento'))) }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Teléfono</td><td style="padding:8px 0;">{{ e($val('telefono')) ?: '—' }}</td></tr>
          <tr>
            <td style="padding:8px 0;color:#6b7280;">Correo</td>
            <td style="padding:8px 0;">
              @php($correo = $val('correo'))
              @if($correo)
                <a href="mailto:{{ e($correo) }}" style="color:#0b67a3;text-decoration:none;font-weight:700;">{{ e($correo) }}</a>
              @else
                —
              @endif
            </td>
          </tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Sucursal</td><td style="padding:8px 0;">{{ e($val('sucursal')) ?: '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Escolaridad</td><td style="padding:8px 0;">{{ e($val('escolaridad')) ?: '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Paquetería Office</td><td style="padding:8px 0;">{{ e($val('office')) ?: '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Años de experiencia</td><td style="padding:8px 0;">{{ e($val('experiencia_anios')) ?: '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">¿Liderazgo?</td><td style="padding:8px 0;">{{ $yn('liderazgo') }}</td></tr>
        </table>

        <hr style="border:none;border-top:1px solid #e5e7eb;margin:18px 0;">

        <h3 style="margin:0 0 10px 0;font-size:16px;">Cuestionario</h3>

        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          @foreach($qa as $row)
            <tr>
              <td style="padding:10px 0;color:#111827;font-weight:700;vertical-align:top;width:520px;">
                {{ $row['q'] }}
              </td>
              <td style="padding:10px 0;color:#0b67a3;font-weight:800;white-space:nowrap;vertical-align:top;text-align:right;">
                {{ $row['a'] }}
              </td>
            </tr>
            <tr><td colspan="2" style="border-top:1px solid #eef2f7;"></td></tr>
          @endforeach
        </table>

        <div style="margin-top:16px;padding:12px 14px;border:1px solid #e5e7eb;border-radius:12px;background:#f9fafb;font-size:13px;color:#374151;">
          <div style="font-weight:800;margin-bottom:4px;">CV</div>
          Si el candidato adjuntó archivo, llega como PDF adjunto en este correo.
        </div>

        <div style="margin-top:18px;font-size:12px;color:#6b7280;">
          Este correo fue generado automáticamente desde el formulario de Vacantes (Subgerente).
        </div>
      </div>
    </div>
  </div>
</body>
</html>
