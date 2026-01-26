{{-- Crédito Comadres (morado / púrpura) --}}
@php
  $brand = [
    'top'   => '#6D28D9', // morado
    'mid'   => '#8B5CF6', // púrpura
    'soft'  => '#F5F3FF', // lavanda muy claro
    'line'  => '#A78BFA',
    'text'  => '#111827',
    'muted' => '#6B7280',
    'card'  => '#FFFFFF',
  ];
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: {{ $brand['soft'] }}; padding: 24px 12px; font-family: Arial, Helvetica, sans-serif;">
  <tr>
    <td align="center">
      <table role="presentation" width="720" cellpadding="0" cellspacing="0" style="max-width:720px; width:100%;">
        {{-- Header --}}
        <tr>
          <td style="background: {{ $brand['top'] }}; padding: 18px 18px; border-radius: 18px 18px 0 0;">
            <div style="font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,.85); font-weight: 700;">
              MR. LANA · FORMULARIO PÚBLICO
            </div>
            <div style="margin-top: 6px; font-size: 22px; font-weight: 900; color: #FFFFFF; line-height: 1.2;">
              Nueva solicitud · Crédito Comadres
            </div>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="background: {{ $brand['card'] }}; padding: 18px; border: 1px solid #E5E7EB; border-top: 0; border-radius: 0 0 18px 18px;">
            {{-- Resumen --}}
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #E5E7EB; border-radius: 14px; overflow: hidden;">
              <tr>
                <td style="background: rgba(109,40,217,.08); padding: 14px 14px; border-bottom: 1px solid #E5E7EB;">
                  <div style="font-size: 14px; font-weight: 900; color: {{ $brand['text'] }};">Resumen del contacto</div>
                  <div style="margin-top:4px; font-size: 12px; color: {{ $brand['muted'] }};">Capturado desde el sitio público.</div>
                </td>
              </tr>

              <tr>
                <td style="padding: 14px;">
                  <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="padding: 10px 0; border-bottom: 1px dashed {{ $brand['line'] }};">
                        <div style="font-size: 12px; font-weight: 800; color: {{ $brand['mid'] }}; text-transform: uppercase;">Sucursal</div>
                        <div style="margin-top: 3px; font-size: 15px; font-weight: 800; color: {{ $brand['text'] }};">
                          {{ $d['branch'] }}
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td style="padding: 10px 0;">
                        <div style="font-size: 12px; font-weight: 800; color: {{ $brand['muted'] }}; text-transform: uppercase;">Cliente</div>
                        <div style="margin-top: 3px; font-size: 15px; font-weight: 900; color: {{ $brand['text'] }};">
                          {{ $d['nombres'] }} {{ $d['apellido1'] }} {{ $d['apellido2'] ?? '' }}
                        </div>

                        <div style="margin-top: 10px; font-size: 12px; font-weight: 800; color: {{ $brand['muted'] }}; text-transform: uppercase;">Correo</div>
                        <div style="margin-top: 3px; font-size: 14px; color: {{ $brand['text'] }};">
                          <a href="mailto:{{ $d['email'] }}" style="color: {{ $brand['top'] }}; text-decoration: none; font-weight: 800;">{{ $d['email'] }}</a>
                        </div>

                        <div style="margin-top: 10px; font-size: 12px; font-weight: 800; color: {{ $brand['muted'] }}; text-transform: uppercase;">Teléfono</div>
                        <div style="margin-top: 3px; font-size: 14px; color: {{ $brand['text'] }}; font-weight: 800;">
                          <a href="tel:{{ $d['telefono'] }}" style="color: {{ $brand['text'] }}; text-decoration: none;">{{ $d['telefono'] }}</a>
                        </div>

                        <div style="margin-top: 10px; font-size: 12px; font-weight: 800; color: {{ $brand['muted'] }}; text-transform: uppercase;">Dirección</div>
                        <div style="margin-top: 3px; font-size: 14px; color: {{ $brand['text'] }};">
                          {{ $d['direccion'] }}
                        </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            {{-- Footer --}}
            <div style="margin-top: 14px; font-size: 12px; color: {{ $brand['muted'] }};">
              © {{ date('Y') }} Mr. Lana. Todos los derechos reservados.
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
