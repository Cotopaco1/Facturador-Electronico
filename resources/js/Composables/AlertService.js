import Swal from "sweetalert2";

export function alertSuccess(title = 'Solicitud exitosa', text = '') {
    Swal.fire({
        icon: 'success',
        title: title,
        text: text,
    });
}

export function alertError(title, text, footer = '') {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text,
        footer: footer || '',
    });
}