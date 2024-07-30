$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2').select2();
});

$(document).ready(function() {
    $('#formKfrBayar').on('submit', function(e) {
        e.preventDefault();
        
        var formData        = new FormData(this);
        var id              = $('#id').val();
        var kode_registrasi = "{{ $peserta->kode_registrasi }}";

        $.ajax({
            type       : 'POST',
            url        : '/konfirmasi/updateBuktiPembayaran/' + id + '/' + kode_registrasi,
            data       : formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.status == 200) {
                    toastr.success(response.message);
                    location.reload();
                } else if (response.status == 400) {
                    toastr.error(response.message);
                    $('#save_errorList').html('');
                    $.each(response.errors, function(key, err_value) {
                        $('#save_errorList').append('<li>' + err_value + '</li>');
                    });
                    $('#save_errorList').removeClass('d-none');
                }
            },
            error: function(response) {
                toastr.error(response.message);
            }
        });
    });
});


// $('#formKfrBayar').on('submit', function(e) {
//     e.preventDefault();

//     // Pastikan status_pembayaran memiliki nilai
//     $('#status_pembayaran').val(1); // atau nilai yang sesuai

//     var formData = new FormData(this);

//     var id = $('#id').val();

//     $.ajax({
//         url: '/konfirmasi/updateBuktiPembayaran/' + id, // Ganti dengan route yang sesuai
//         type: 'POST',
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function(response) {
//             if(response.status === 200) {
//                 toastr.success(response.message);
//                 location.reload();
//             } else if (response.status === 400) {
//                 toastr.error(response.message);
//             } else {
//                 toastr.error(response.message);
//             }
//         },
//         error: function(xhr) {
//             alert('Terjadi kesalahan. Silakan coba lagi.');
//         }
//     });
// });
