import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
const SWAL_KEY = '__active_swal__'

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
    return Swal.fire({
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

// “notificación global” (sirve para success/error/info)
export function swalNotify(
    variant: 'success' | 'error' | 'info' | 'warning',
    title: string,
    text?: string
) {
    //  guardamos el estado
    sessionStorage.setItem(
        SWAL_KEY,
        JSON.stringify({ variant, title, text })
    )

    return Swal.fire({
        icon: variant,
        title,
        text: text || '',
        confirmButtonText: 'OK',
        showCloseButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        heightAuto: false,
    }).then(() => {
        // SOLO se borra cuando el usuario cierra
        sessionStorage.removeItem(SWAL_KEY)
    })
}
