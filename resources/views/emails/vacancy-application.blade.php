<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body style="font-family: Arial, sans-serif; color:#111; line-height:1.4;">
  <h2 style="margin:0 0 10px;">Nueva postulación: {{ $vacancyLabel }}</h2>

  <p style="margin:0 0 12px;">
    Se recibió una nueva postulación desde el sitio.
  </p>

  <table cellpadding="8" cellspacing="0" border="0" style="border-collapse:collapse; width:100%; max-width:720px;">
    @foreach($data as $k => $v)
      <tr>
        <td style="border:1px solid #eee; width:220px; background:#fafafa;"><b>{{ $k }}</b></td>
        <td style="border:1px solid #eee;">{{ is_array($v) ? json_encode($v) : $v }}</td>
      </tr>
    @endforeach
  </table>

  <p style="margin:14px 0 0; font-size:12px; color:#555;">
    Mr. Lana — Bolsa de trabajo
  </p>
</body>
</html>
