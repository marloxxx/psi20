$("body").on("contextmenu", "img", function (e) {
    return false;
});
var audio = document.getElementById("audio");
$('img').attr('draggable', false);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            // load_list(1);
        }
    });
});

function handle_confirm(title, confirm_title, deny_title, method, route) {
    Swal.fire({
        title: title,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: confirm_title,
        denyButtonText: deny_title,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: method,
                url: route,
                dataType: 'json',
                success: function (response) {
                    $('#datatables').DataTable().ajax.reload();
                    Swal.fire(response.message, '', response.status)
                },
                error: function (response) {
                    Swal.fire(response.responseJSON.message, '', 'error')
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Konfirmasi dibatalkan', '', 'info')
        }
    });
}
