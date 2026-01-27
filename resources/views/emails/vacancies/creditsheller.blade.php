<!doctype html>
<html lang="es">
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
  <div style="max-width:720px;margin:0 auto;padding:24px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">
      <div style="padding:18px 20px;background:#0b67a3;color:#fff;">
        <div style="font-size:14px;opacity:.9;">Mr Lana</div>
        <div style="font-size:20px;font-weight:800;margin-top:4px;">Postulación: Vendedor de Crédito</div>
      </div>

      <div style="padding:20px;">
        <h3 style="margin:0 0 10px 0;font-size:16px;">Datos del candidato</h3>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6b7280;width:220px;">Nombre</td><td style="padding:8px 0;font-weight:700;">{{ $data['nombre'] ?? '' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Teléfono</td><td style="padding:8px 0;">{{ $data['telefono'] ?? '' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Correo</td><td style="padding:8px 0;">{{ $data['correo'] ?? '' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Sucursal</td><td style="padding:8px 0;">{{ $data['sucursal'] ?? '' }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Años de experiencia</td><td style="padding:8px 0;">{{ $data['experiencia_anios'] ?? '' }}</td></tr>
        </table>

        <hr style="border:none;border-top:1px solid #e5e7eb;margin:18px 0;">

        <h3 style="margin:0 0 10px 0;font-size:16px;">Notas</h3>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6b7280;width:220px;">Experiencia en ventas</td><td style="padding:8px 0;">{{ ($data['p_experiencia_ventas'] ?? '') === 'si' ? 'Sí' : (($data['p_experiencia_ventas'] ?? '') === 'no' ? 'No' : '') }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Experiencia cobranza</td><td style="padding:8px 0;">{{ ($data['p_cobranza'] ?? '') === 'si' ? 'Sí' : (($data['p_cobranza'] ?? '') === 'no' ? 'No' : '') }}</td></tr>
          <tr><td style="padding:8px 0;color:#6b7280;">Cómodo con meta diaria</td><td style="padding:8px 0;">{{ ($data['p_meta_diaria'] ?? '') === 'si' ? 'Sí' : (($data['p_meta_diaria'] ?? '') === 'no' ? 'No' : '') }}</td></tr>
        </table>

        <div style="margin-top:16px;padding:12px 14px;border:1px solid #e5e7eb;border-radius:12px;background:#f9fafb;font-size:13px;color:#374151;">
          CV: si el candidato adjuntó archivo, llega como PDF adjunto en este correo.
        </div>
      </div>
    </div>
  </div>
</body>
</html>
