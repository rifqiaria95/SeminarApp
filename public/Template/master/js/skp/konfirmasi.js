$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});


//MULAI DATATABLE
//script untuk memanggil data json dari server dan menampilkannya berupa datatable
$(document).ready(function() {
    // $.noConflict();
    $('#table-konfirmasi').DataTable({
        processing: true,
        serverSide: true, //aktifkan server-side 
        ajax: {
            url: "/konfirmasi",
            type: 'GET'
        },
        columns: [{
                data: 'kode_registrasi',
                name: 'kode_registrasi'
            },
            {
                data: 'nama_lengkap',
                name: 'nama_lengkap'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'judul',
                name: 'judul'
            },
            {
                data: 'bukti_pembayaran',
                name: 'bukti_pembayaran'
            },
            {
                data: 'status_pembayaran',
                name: 'status_pembayaran'
            },
            {
                data: 'aksi',
                name: 'aksi'
            },
        ],
        order: [
            [0, 'asc']
        ],
        
    });
});


// Function Edit konfirmasi
$(document).on('click', '.edit-konfirmasi', function(e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#editModal').modal('show');
    $('#titleEdit').html("Konfirmasi Pembayaran");
    $('#status_pembayaran').select2({
        dropdownParent: $('#editModal')
    });

    $.ajax({
        type: "GET",
        url: "/konfirmasi/edit/" + id,
        success: function(response) {
            console.log(response);
            // Jika sukses maka munculkan notifikasi
            if (response.status == 404) {
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#editModal').modal('hide');
            } else {
                $('#id').val(id);
                $('#status_pembayaran').val(response.status_pembayaran).trigger('change');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
    $('.btn-close').find('input').val('');

});


// Function update data konfirmasi
$('#formEdit').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var id = $('#id').val(); // Get the participant ID from hidden input
    var status_pembayaran = $('#status_pembayaran').val(); // Get the payment status

    // Serialize the form data
    var formData = $(this).serialize();

    $.ajax({
        url: '/konfirmasi/update/' + id, // URL to update participant data
        type: 'POST',
        data: formData, // Serialize form data
        success: function(response) {
            if (response.status == 200) {
                console.log(response);
                $('#editModal').modal('hide'); // Hide the modal on success
                var oTable = $('#table-konfirmasi').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
                toastr.success(response.message);

                // Generate QR code if status_pembayaran is 1
                if (status_pembayaran == '1') {
                    var qrCodeImageUrl = '/' + response.qr_code;
                    $('#qrCodeImage').attr('src', qrCodeImageUrl);
                    $('.qr-code').show(); // Show the QR code container
                } else {
                    $('.qr-code').hide(); // Hide QR code container if status is not 1
                }
            }
        },
        error: function(xhr) {
            $('.save_errorlist').html(''); // Clear previous error messages
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, error) {
                $('.save_errorlist').append('<li>' + error[0] + '</li>'); // Show errors
            });
        }
    });
});