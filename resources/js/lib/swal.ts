import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

export function swalOk(text: string) {
  return Swal.fire({
    icon: 'success',
    title: 'Enviado',
    text,
    confirmButtonText: 'OK',
    heightAuto: false,
  })
}

export function swalErr(text: string) {
  return Swal.fire({
    icon: 'error',
    title: 'Error',
    text,
    confirmButtonText: 'Entendido',
    heightAuto: false,
  })
}

export function swalLoading(text = 'Enviando...') {
  Swal.fire({
    title: text,
    allowOutsideClick: false,
    allowEscapeKey: false,
    didOpen: () => Swal.showLoading(),
    heightAuto: false,
  })
}

export function swalClose() {
  Swal.close()
}
