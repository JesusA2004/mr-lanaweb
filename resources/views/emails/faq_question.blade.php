@php
  $brand = [
    'top'   => '#10B981', // verde Mr.Lana vibe
    'mid'   => '#06B6D4', // agua
    'soft'  => '#ECFDF5', // fondo suave
    'line'  => '#A7F3D0',
    'text'  => '#0F172A',
    'muted' => '#475569',
    'card'  => '#FFFFFF',
  ];
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: {{ $brand['soft'] }}; padding: 24px 12px; font-family: Arial, Helvetica, sans-serif;">
  <tr>
    <td align="center">
      <table role="presentation" width="720" cellpadding="0" cellspacing="0" style="max-width:720px; width:100%;">
        <tr>
          <td style="background: {{ $brand['top'] }}; padding: 18px; border-radius: 18px 18px 0 0;">
            <div style="font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,.9); font-weight: 700;">
              MR. LANA · FAQs
            </div>
            <div style="margin-top: 6px; font-size: 22px; font-weight: 900; color: #FFFFFF; line-height: 1.2;">
              Nueva pregunta desde el sitio
            </div>
          </td>
        </tr>

        <tr>
          <td style="background: {{ $brand['card'] }}; padding: 18px; border: 1px solid #E5E7EB; border-top: 0; border-radius: 0 0 18px 18px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #E5E7EB; border-radius: 14px; overflow:hidden;">
              <tr>
                <td style="background: rgba(6,182,212,.10); padding: 14px; border-bottom: 1px solid #E5E7EB;">
                  <div style="font-size: 14px; font-weight: 900; color: {{ $brand['text'] }};">Datos del contacto</div>
                  <div style="margin-top:4px; font-size: 12px; color: {{ $brand['muted'] }};">Capturado desde la página de FAQs.</div>
                </td>
              </tr>

              <tr>
                <td style="padding: 14px;">
                  <div style="font-size: 12px; font-weight: 800; color: {{ $brand['mid'] }}; text-transform: uppercase;">Nombre</div>
                  <div style="margin-top: 4px; font-size: 15px; font-weight: 900; color: {{ $brand['text'] }};">
                    {{ $d['nombre'] }}
                  </div>

                  <div style="margin-top: 12px; font-size: 12px; font-weight: 800; color: {{ $brand['mid'] }}; text-transform: uppercase;">Correo</div>
                  <div style="margin-top: 4px; font-size: 14px; color: {{ $brand['text'] }};">
                    <a href="mailto:{{ $d['email'] }}" style="color: {{ $brand['top'] }}; text-decoration:none; font-weight: 800;">
                      {{ $d['email'] }}
                    </a>
                  </div>

                  <div style="margin-top: 14px; border-top: 1px dashed {{ $brand['line'] }}; padding-top: 14px;">
                    <div style="font-size: 12px; font-weight: 900; color: {{ $brand['text'] }}; text-transform: uppercase;">
                      Pregunta
                    </div>
                    <div style="margin-top: 8px; font-size: 14px; line-height: 1.55; color: {{ $brand['text'] }}; white-space: pre-wrap;">
                      {{ $d['pregunta'] }}
                    </div>
                  </div>
                </td>
              </tr>
            </table>

            <div style="margin-top: 14px; font-size: 12px; color: {{ $brand['muted'] }};">
              © {{ date('Y') }} Mr. Lana. Todos los derechos reservados.
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
