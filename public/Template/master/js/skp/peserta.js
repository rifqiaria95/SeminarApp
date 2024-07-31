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
            url: "/peserta",
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
                data: 'seminar',
                name: 'seminar'
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

    if (userRole === 'owner') {
        tableOptions.buttons.push({
            text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah Peserta</span>',
            className: 'btn_tambah add-new btn btn-primary mx-3',
            attr: {
                'data-bs-toggle': 'tambahModal',
                'data-bs-target': '#tambahModal'
            }
        });
    }

    $('#table-peserta').DataTable(tableOptions);
});

// Function untuk tombol tambah peserta dan tampilkan modal
$(document).ready(function() {
    // $.noConflict();
    $('.btn_tambah').click(function() {
        // console.log($('#btn_tambah'));
        $('#btn-simpan').val("tambah-peserta");
        $('#tambahModal').modal('show');
        $('#formpembicara').trigger("reset");
        $('#modal-judul').html("Tambah Peserta");
        $('#selectSeminar').select2({
            dropdownParent: $('#tambahModal')
        });
    });
});


//SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
//jika id = formPeserta panjangnya lebih dari 0 atau bisa dibilang terdapat data dalam form tersebut maka
//jalankan jquery validator terhadap setiap inputan dll dan eksekusi script ajax untuk simpan data
if ($("#formPeserta").length > 0) {
    $("#formPeserta").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-simpan').val();
            // Mengubah data menjadi objek agar file image bisa diinput kedalam database
            var formData = new FormData($('#formPeserta')[0]);
            $.ajax({
                data: formData, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                url: "/peserta/store", //url simpan data
                type: "POST", //data tipe kita kirim berupa JSON
                contentType: false,
                processData: false,
                success: function(response) {
                    var oTable = $('#table-peserta').dataTable(); //inialisasi datatable
                    oTable.fnDraw(false); //reset datatable
                    if (response.status == 400) {
                        $('.save_errorlist').html("");
                        $('.save_errorlist').removeClass('d-none');
                        $.each(response.errors, function(key, err_value) {
                            $('.save_errorlist').append('<li>' + err_value +
                                '</li>');
                        });

                        $('#btn-simpan').text('Menyimpan..');
                    } else if (response.status == 200) {
                        $('#modalJudul').html("");
                        $('#formPeserta').find('input').val('');
                        toastr.success(response.message);
                        $('#tambahModal').modal('hide');

                    }
                },
                error: function(response) {
                    console.log('Error:', response);
                    $('#btn-simpan').html('Simpan');
                }
            });
        }
    })
}


// Function Edit peserta
$(document).on('click', '.edit-peserta', function(e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#editModal').modal('show');
    $('#titleEdit').html("Edit Data peserta");
    $('#data_seminar_id').select2({
        dropdownParent: $('#editModal')
    });

    $.ajax({
        type: "GET",
        url: "/peserta/edit/" + id,
        success: function(response) {
            console.log(response);
            // Jika sukses maka munculkan notifikasi
            if (response.status == 404) {
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#editModal').modal('hide');
            } else {
                $('#id').val(id);
                $('#nama_lengkap').val(response.nama_lengkap);
                $('#phone').val(response.phone);
                $('#email').val(response.email);
                $('#company').val(response.company);
                $('#data_seminar_id').val(response.data_seminar_id).trigger('change');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
    $('.btn-close').find('input').val('');

});


// Function update data peserta
$('#formEdit').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var id = $('#id').val(); // Get the participant ID from hidden input
    var status_pembayaran = $('#status_pembayaran').val(); // Get the payment status

    // Serialize the form data
    var formData = $(this).serialize();

    $.ajax({
        url: '/peserta/update/' + id, // URL to update participant data
        type: 'PUT',
        data: formData, // Serialize form data
        success: function(response) {
            if (response.status == 200) {
                $('#editModal').modal('hide'); // Hide the modal on success
                var oTable = $('#table-peserta').dataTable(); //inialisasi datatable
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

// Function delete data peserta
//jika klik class delete (yang ada pada tombol delete) maka tampilkan modal konfirmasi hapus maka
$('body').on('click', '.delete', function() {
    id = $(this).attr('id');
    $('#modalHapus').modal('show');
});
//jika tombol hapus pada modal konfirmasi di klik maka
$('#btn-hapus').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "/peserta/delete/" + id, //eksekusi ajax ke url ini
        type: 'delete',
        beforeSend: function() {
            $('#btn-hapus').text('Hapus Data...'); //set text untuk tombol hapus
        },
        success: function(response) { //jika sukses
            setTimeout(function() {
                $('#modalHapus').modal('hide');
                var oTable = $('#table-peserta').dataTable();
                oTable.fnDraw(false); //reset datatable
                if (response.status == 404) {
                    toastr.success(response.message);
                } else if (response.status == 200) {
                    toastr.success(response.message);
                }
            });
        },
        error: function(response) {
            console.log('Error:', response);
        }
    })
});