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
    var tableOptions = {
        dom:
            '<"row me-2"' +
            '<"col-md-2"<"me-3"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
        },
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-3',
                text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                buttons: [
                {
                    extend: 'print',
                    text: '<i class="ti ti-printer me-2" ></i>Print',
                    className: 'dropdown-item',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                    // prevent avatar to be print
                    format: {
                        body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function (index, item) {
                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                            } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                            } else result = result + item.innerText;
                        });
                        return result;
                        }
                    }
                    },
                    customize: function (win) {
                    //customize print view for dark
                    $(win.document.body)
                        .css('color', headingColor)
                        .css('border-color', borderColor)
                        .css('background-color', bodyBg);
                    $(win.document.body)
                        .find('table')
                        .addClass('compact')
                        .css('color', 'inherit')
                        .css('border-color', 'inherit')
                        .css('background-color', 'inherit');
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                    className: 'dropdown-item',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                    // prevent avatar to be display
                    format: {
                        body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function (index, item) {
                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                            } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                            } else result = result + item.innerText;
                        });
                        return result;
                        }
                    }
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                    className: 'dropdown-item',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                    // prevent avatar to be display
                    format: {
                        body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function (index, item) {
                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                            } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                            } else result = result + item.innerText;
                        });
                        return result;
                        }
                    }
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                    className: 'dropdown-item',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                    // prevent avatar to be display
                    format: {
                        body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function (index, item) {
                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                            } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                            } else result = result + item.innerText;
                        });
                        return result;
                        }
                    }
                    }
                },
                {
                    extend: 'copy',
                    text: '<i class="ti ti-copy me-2" ></i>Copy',
                    className: 'dropdown-item',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                    // prevent avatar to be display
                    format: {
                        body: function (inner, coldex, rowdex) {
                        if (inner.length <= 0) return inner;
                        var el = $.parseHTML(inner);
                        var result = '';
                        $.each(el, function (index, item) {
                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                            result = result + item.lastChild.firstChild.textContent;
                            } else if (item.innerText === undefined) {
                            result = result + item.textContent;
                            } else result = result + item.innerText;
                        });
                        return result;
                        }
                    }
                    }
                }
                ]
            },
        ],
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
    };

    $('#table-konfirmasi').DataTable(tableOptions);
    
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