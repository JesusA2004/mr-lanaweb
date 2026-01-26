<h2>Nueva solicitud ({{ $d['context'] }})</h2>
<p><b>Sucursal:</b> {{ $d['branch'] }}</p>
<hr>
<p><b>Nombre:</b> {{ $d['nombres'] }} {{ $d['apellido1'] }} {{ $d['apellido2'] ?? '' }}</p>
<p><b>Email:</b> {{ $d['email'] }}</p>
<p><b>Teléfono:</b> {{ $d['telefono'] }}</p>
<p><b>Dirección:</b> {{ $d['direccion'] }}</p>

@if(($d['context'] ?? '') === 'impulsa_negocio')
  <hr>
  <p><b>Negocio físico:</b> {{ $d['negocioFisico'] }}</p>
  @if(($d['negocioFisico'] ?? '') === 'Si')
    <p><b>Giro:</b> {{ $d['giroNegocio'] }}</p>
  @endif
@endif

@if(($d['context'] ?? '') === 'impulsat')
  <hr>
  <p><b>Empleo:</b> {{ $d['empleoCuenta'] }}</p>
  <p><b>Tipo empleo:</b> {{ $d['tipoEmpleo'] }}</p>
@endif
