<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Postulación: Gerente</title>
</head>

<body style="margin:0;padding:0;background:#eef7f7;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,Helvetica,sans-serif;color:#0f172a;">
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

    // p4_accion: analizo | reporteo | presiono
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

    $ts = now();

    $nombre      = $val('nombre','—') ?: '—';
    $fechaNac    = $fmtDate($val('fecha_nacimiento'));
    $telefono    = $val('telefono');
    $correo      = $val('correo');
    $sucursal    = $val('sucursal') ?: '—';
    $escolaridad = $val('escolaridad') ?: '—';
    $office      = $val('office') ?: '—';
    $expAnios    = $val('experiencia_anios') ?: '—';
    $liderazgo   = $yn('liderazgo');

    // Detectar si hay PDF
    $hasCv  = (bool) data_get($data, 'has_cv', false);
    $cvName = data_get($data, 'cv_name');

    // Helpers UI
    $pill = function(string $text, string $bg, string $bd, string $fg) {
        return '<span style="display:inline-block;background:'.$bg.';border:1px solid '.$bd.';color:'.$fg.';border-radius:999px;padding:8px 12px;font-size:13px;font-weight:900;line-height:1;">'.$text.'</span>';
    };
@endphp

  <!-- Preheader -->
  <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
    Se recibió una postulación para Gerente. Datos, cuestionario y CV (si aplica).
  </div>

  <!-- Wrapper -->
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#eef7f7;margin:0;padding:0;">
    <tr>
      <td align="center" style="padding:20px 12px;">

        <!-- Container -->
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:680px;width:100%;">
          <!-- Top bar -->
          <tr>
            <td style="padding:0 2px 12px 2px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td align="left" style="font-size:12px;color:#0f766e;">
                    <span style="display:inline-block;background:#d8f3f1;border:1px solid #b8ece7;border-radius:999px;padding:7px 12px;font-weight:900;color:#0f766e;">
                      Mr Lana · Reclutamiento
                    </span>
                  </td>
                  <td align="right" style="font-size:12px;color:#64748b;">
                    <span style="display:inline-block;background:#ffffff;border:1px solid #e5e7eb;border-radius:999px;padding:7px 12px;font-weight:800;color:#0f172a;">
                      {{ $ts->format('Y-m-d H:i') }}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Main card -->
          <tr>
            <td>
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                     style="background:#ffffff;border-radius:30px;overflow:hidden;border:1px solid #e6f6f5;box-shadow:0 18px 60px rgba(15,23,42,.10);">

                <!-- Header -->
                <tr>
                  <td style="padding:0;background:#062a2a;">
                    <div style="height:7px;background:linear-gradient(90deg,#2dd4bf,#60a5fa,#34d399,#a78bfa);"></div>

                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                      <tr>
                        <td style="padding:18px 18px 14px 18px;">
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                              <td style="vertical-align:top;">
                                <div style="font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.78);font-weight:900;">
                                  Nueva postulación
                                </div>
                                <div style="margin-top:6px;font-size:26px;line-height:1.15;font-weight:1000;color:#ffffff;">
                                  Gerente
                                </div>
                              </td>
                              <td align="right" style="vertical-align:top;padding-left:10px;">
                                <span style="display:inline-block;background:rgba(45,212,191,.18);border:1px solid rgba(45,212,191,.35);color:#eafffd;border-radius:999px;padding:9px 12px;font-size:12px;font-weight:1000;">
                                  Estado · Nueva
                                </span>
                              </td>
                            </tr>
                          </table>

                          <div style="height:8px;line-height:8px;">&nbsp;</div>

                          <div>
                            <span style="display:inline-block;margin:0 8px 8px 0;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:8px 12px;font-size:12px;color:#ffffff;font-weight:900;">
                              Canal: Sitio web
                            </span>
                            <span style="display:inline-block;margin:0 8px 8px 0;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:8px 12px;font-size:12px;color:#ffffff;font-weight:900;">
                              Recibida: {{ $ts->format('d/m/Y H:i') }}
                            </span>
                            @if($hasCv)
                              <span style="display:inline-block;margin:0 8px 8px 0;background:rgba(16,185,129,.18);border:1px solid rgba(16,185,129,.35);border-radius:999px;padding:8px 12px;font-size:12px;color:#ecfdf5;font-weight:1000;">
                                CV: Adjuntado (PDF)
                              </span>
                            @else
                              <span style="display:inline-block;margin:0 8px 8px 0;background:rgba(245,158,11,.18);border:1px solid rgba(245,158,11,.35);border-radius:999px;padding:8px 12px;font-size:12px;color:#fff7ed;font-weight:1000;">
                                CV: No adjuntó
                              </span>
                            @endif
                          </div>
                        </td>
                      </tr>

                      <!-- Candidate spotlight -->
                      <tr>
                        <td style="padding:0 18px 18px 18px;">
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                 style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);border-radius:26px;">
                            <tr>
                              <td style="padding:14px 14px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                  <tr>
                                    <td style="vertical-align:middle;">
                                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                          <td style="width:54px;height:54px;border-radius:999px;background:rgba(45,212,191,.22);border:1px solid rgba(45,212,191,.38);text-align:center;vertical-align:middle;">
                                            <span style="display:inline-block;font-size:20px;line-height:54px;color:#eafffd;font-weight:1000;">ML</span>
                                          </td>
                                          <td style="padding-left:12px;">
                                            <div style="font-size:14px;color:rgba(255,255,255,.78);font-weight:900;letter-spacing:.06em;text-transform:uppercase;">
                                              Nombre:
                                            </div>
                                            <div style="margin-top:2px;font-size:20px;line-height:1.2;font-weight:1000;color:#ffffff;">
                                              {{ e($nombre) }}
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>

                                    <td align="right" style="vertical-align:middle;padding-left:10px;">
                                      <div style="text-align:right;">
                                        <div style="font-size:12px;color:rgba(255,255,255,.70);font-weight:900;letter-spacing:.06em;text-transform:uppercase;">Teléfono:</div>
                                        <div style="margin-top:2px;font-size:16px;color:#ffffff;font-weight:1000;">{{ e($telefono) ?: '—' }}</div>

                                        <div style="height:8px;line-height:8px;">&nbsp;</div>

                                        <div style="font-size:12px;color:rgba(255,255,255,.70);font-weight:900;letter-spacing:.06em;text-transform:uppercase;">Correo:</div>
                                        <div style="margin-top:2px;font-size:16px;color:#ffffff;font-weight:1000;">{{ e($correo) ?: '—' }}</div>
                                      </div>
                                    </td>
                                  </tr>
                                </table>

                                @if(!$hasCv)
                                  <div style="margin-top:12px;background:rgba(245,158,11,.14);border:1px solid rgba(245,158,11,.30);border-radius:999px;padding:10px 12px;color:#fff7ed;font-weight:900;font-size:12px;line-height:1.4;text-align:center;">
                                    El postulante no adjuntó archivo PDF.
                                  </div>
                                @endif

                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Body -->
                <tr>
                  <td style="padding:18px 18px 20px 18px;">

                    <div style="font-size:14px;font-weight:1000;color:#0f172a;letter-spacing:.02em;margin-bottom:10px;">
                      Información del candidato
                    </div>

                    <!-- Fields (gerente) -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                      <tr>
                        <td style="padding:0;">
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">

                            <tr>
                              <td width="50%" style="padding-right:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Fecha de nacimiento</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ e($fechaNac) }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>

                              <td width="50%" style="padding-left:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Sucursal</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ e($sucursal) }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                            <tr><td colspan="2" style="height:10px;line-height:10px;">&nbsp;</td></tr>

                            <tr>
                              <td width="50%" style="padding-right:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Escolaridad</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ e($escolaridad) }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>

                              <td width="50%" style="padding-left:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Paquetería Office</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ e($office) }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                            <tr><td colspan="2" style="height:10px;line-height:10px;">&nbsp;</td></tr>

                            <tr>
                              <td width="50%" style="padding-right:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Años de experiencia</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ e($expAnios) }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>

                              <td width="50%" style="padding-left:6px;vertical-align:top;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                       style="background:#f3fffd;border:1px solid #c8f3ed;border-radius:999px;">
                                  <tr>
                                    <td style="padding:10px 14px;">
                                      <div style="font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;">Liderazgo</div>
                                      <div style="margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">{{ $liderazgo }}</div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                          </table>
                        </td>
                      </tr>
                    </table>

                    <div style="height:14px;line-height:14px;">&nbsp;</div>

                    <div style="font-size:14px;font-weight:1000;color:#0f172a;letter-spacing:.02em;margin-bottom:10px;">
                      Cuestionario de evaluación
                    </div>

                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                      @foreach($qa as $row)
                        @php($ans = trim((string)($row['a'] ?? '—')))
                        @php($isYes = mb_strtolower($ans) === 'sí')
                        @php($isNo  = mb_strtolower($ans) === 'no')

                        <tr>
                          <td style="padding:0 0 10px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                   style="background:#ffffff;border:1px solid #e6f6f5;border-radius:26px;box-shadow:0 10px 26px rgba(15,23,42,.06);">
                              <tr>
                                <td style="padding:14px 14px;">
                                  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td style="vertical-align:top;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                            <td style="width:30px;height:30px;border-radius:999px;background:#d8f3f1;border:1px solid #b8ece7;text-align:center;vertical-align:middle;">
                                              <span style="display:inline-block;font-size:12px;line-height:30px;font-weight:1000;color:#0f766e;">{{ $loop->iteration }}</span>
                                            </td>
                                            <td style="padding-left:10px;">
                                              <div style="font-size:13px;line-height:1.5;color:#0f172a;font-weight:900;">
                                                {{ $row['q'] }}
                                              </div>
                                              <div style="margin-top:8px;font-size:11px;color:#0f766e;font-weight:1000;letter-spacing:.10em;text-transform:uppercase;">
                                                Respuesta
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>

                                      <td align="right" style="vertical-align:top;padding-left:10px;">
                                        @if($isYes)
                                          {!! $pill('Sí', '#d1fae5', '#bbf7d0', '#065f46') !!}
                                        @elseif($isNo)
                                          {!! $pill('No', '#fee2e2', '#fecaca', '#991b1b') !!}
                                        @else
                                          <span style="display:inline-block;background:#f3fffd;border:1px solid #c8f3ed;color:#0f172a;border-radius:999px;padding:8px 12px;font-size:13px;font-weight:900;max-width:320px;text-align:center;">
                                            {{ $ans ?: '—' }}
                                          </span>
                                        @endif
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      @endforeach
                    </table>

                    <!-- CV strip -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:4px;">
                      <tr>
                        <td>
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                 style="background:#ecfeff;border:1px solid #bae6fd;border-radius:999px;">
                            <tr>
                              <td style="padding:12px 14px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                  <tr>
                                    <td style="vertical-align:middle;">
                                      <span style="display:inline-block;width:34px;height:34px;border-radius:999px;background:#14b8a6;color:#ffffff;font-weight:1000;text-align:center;line-height:34px;">
                                        CV
                                      </span>
                                      <span style="display:inline-block;padding-left:10px;vertical-align:middle;">
                                        <span style="display:block;font-size:12px;color:#0f766e;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;"> Adjunto</span>
                                        @if($hasCv)
                                          <span style="display:block;margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">Se adjuntó archivo PDF.</span>
                                        @else
                                          <span style="display:block;margin-top:2px;font-size:13px;color:#0f172a;font-weight:900;">El postulante no adjuntó archivo PDF.</span>
                                        @endif
                                      </span>
                                    </td>

                                    <td align="right" style="vertical-align:middle;">
                                      @if($hasCv)
                                        {!! $pill('OK', '#d1fae5', '#bbf7d0', '#065f46') !!}
                                      @else
                                        {!! $pill('Faltante', '#ffedd5', '#fed7aa', '#9a3412') !!}
                                      @endif
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <div style="height:14px;line-height:14px;">&nbsp;</div>

                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                      <tr>
                        <td style="font-size:11px;line-height:1.6;color:#64748b;">
                          <div style="font-weight:1000;color:#0f766e;">Nota operativa</div>
                          <div>Correo generado automáticamente desde el formulario de Vacantes del sitio web de Mr Lana.</div>
                        </td>
                      </tr>
                    </table>

                  </td>
                </tr>
              </table>

              <div style="text-align:center;margin-top:14px;color:#94a3b8;font-size:11px;line-height:1.6;">
                <div style="font-weight:1000;color:#0f766e;">Mr Lana · Reclutamiento</div>
              </div>

            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>
