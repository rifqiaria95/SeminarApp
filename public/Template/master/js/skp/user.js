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
    $('#table-user').DataTable({
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
            {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah User</span>',
                className: 'btn_tambah add-new btn btn-primary mx-3',
                attr: {
                    'data-bs-toggle': 'tambahModal',
                    'data-bs-target': '#tambahModal'
                }
            },
        ],
        processing: true,
        serverSide: true, //aktifkan server-side 
        ajax: {
            url: "/user",
            type: 'GET'
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'status_user',
                name: 'status_user'
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


// Function untuk tombol tambah user dan tampilkan modal
$(document).ready(function() {
    // $.noConflict();
    $('.btn_tambah').click(function() {
        // console.log($('#btn_tambah'));
        $('#btn-simpan').val("tambah-user");
        $('#tambahModal').modal('show');
        $('#formUser').trigger("reset");
        $('#modal-judul').html("Tambah User");
        $('.selectRole').select2({
            dropdownParent: $('#tambahModal')
        });
        $('.selectStatus').select2({
            dropdownParent: $('#tambahModal')
        });
    });
});


// SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
if ($("#formUser").length > 0) {
    $("#formUser").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-simpan').val();
            var formData = new FormData($('#formUser')[0]);

            $.ajax({
                data: formData,
                url: "/user/store",
                type: "POST",
                contentType: false,
                processData: false,
                success: function(response) {
                    var oTable = $('#table-user').dataTable(); //inisialisasi datatable
                    oTable.fnDraw(false); //reset datatable
                    if (response.status == 400) {
                        $('#save_errorList').html(''); // Kosongkan daftar error sebelumnya
                        $('#save_errorList').removeClass('d-none');
                        $.each(response.errors, function(key, err_value) {
                            $('#save_errorList').append('<li>' + err_value + '</li>');
                        });
                        $('#btn-simpan').text('Simpan');
                    } else if (response.status == 200) {
                        $('#modalJudul').html("");
                        $('#formUser').find('input').val('');
                        $('#formUser').find('select').val(null).trigger('change'); // Reset select2
                        toastr.success(response.message);
                        $('#tambahModal').modal('hide');
                    }
                },
                error: function(response) {
                    console.log('Error:', response);
                    $('#save_errorList').html('Terjadi kesalahan, silakan coba lagi.');
                    $('#save_errorList').removeClass('d-none');
                    $('#btn-simpan').html('Simpan');
                }
            });
        }
    });
}


// Function Edit User
$(document).on('click', '.edit-user', function(e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#editModal').modal('show');
    $('#titleEdit').html("Edit Data User");

    $.ajax({
        type: "GET",
        url: "/user/edit/" + id,
        success: function(response) {
            // console.log(response);
            // Jika sukses maka munculkan notifikasi
            if (response.status == 404) {
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#editModal').modal('hide');
            } else {
                $('#id').val(id);
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#password').val(response.password).trigger('change');
                $('#role').val(response.role);
                $('#status_user').val(response.status_user);
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
    $('.btn-close').find('input').val('');

});

// Function Update Data User
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    var id = $('#id').val();
    var EditFormData = new FormData($('#formEdit')[0]);

    // Log data untuk debugging
    for (var pair of EditFormData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    $('#btn-update').text('Updating...').prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "/user/update/" + id,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function(response) {
            handleAjaxSuccess(response);
        },
        error: function(response) {
            handleAjaxError(response);
        },
        complete: function() {
            $('#btn-update').text('Update').prop('disabled', false);
        }
    });
});


function handleAjaxSuccess(response) {
    var oTable = $('#table-user').dataTable(); //inialisasi datatable
    oTable.fnDraw(false); //reset datatable

    if (response.status == 400) {
        $('#modalJudulEdit').html("");
        $('#modalJudulEdit').removeClass('d-none');
        $.each(response.errors, function(key, err_value) {
            $('#modalJudulEdit').append('<li>' + err_value + '</li>');
        });
    } else if (response.status == 404) {
        toastr.error(response.errors); // Menggunakan toastr.error untuk pesan kesalahan
    } else if (response.status == 200) {
        $('#modalJudulEdit').html("");
        toastr.success(response.message);

        $('#editModal').modal('hide');
    }
}

function handleAjaxError(response) {
    console.log('Error:', response);
    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
}


// Function Delete
//jika klik class delete (yang ada pada tombol delete) maka tampilkan modal konfirmasi hapus maka
$('body').on('click', '.delete', function() {
    id = $(this).attr('id');
    $('#modalHapus').modal('show');
});
//jika tombol hapus pada modal konfirmasi di klik maka
$('#btn-hapus').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "/user/delete/" + id, //eksekusi ajax ke url ini
        type: 'delete',
        beforeSend: function() {
            $('#btn-hapus').text('Hapus Data...'); //set text untuk tombol hapus
        },
        success: function(response) { //jika sukses
            setTimeout(function() {
                $('#modalHapus').modal('hide');
                var oTable = $('#table-user').dataTable();
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