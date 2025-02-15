// swet alert
document.addEventListener('DOMContentLoaded', function () {
    if (typeof error !== 'undefined') {
        Swal.fire({
            title: "Maaf...",
            text: error,
            icon: "error"
        });
    } else if (typeof success !== 'undefined') {
        Swal.fire({
            title: "Berhasil!",
            text: success,
            icon: "success"
        });
    }
});