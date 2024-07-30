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
    $('#table-pembicara').DataTable({
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
            text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah Pembicara</span>',
            className: 'btn_tambah add-new btn btn-primary mx-3',
            attr: {
                'data-bs-toggle': 'tambahModal',
                'data-bs-target': '#tambahModal'
            }
        }
        ],
        processing: true,
        serverSide: true, //aktifkan server-side 
        ajax: {
            url: "/pembicara",
            type: 'GET'
        },
        columns: [{
                data: 'nama_lengkap',
                name: 'nama_lengkap'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'company',
                name: 'company'
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


// Function untuk tombol tambah pembicara dan tampilkan modal
$(document).ready(function() {
    // $.noConflict();
    $('.btn_tambah').click(function() {
        // console.log($('#btn_tambah'));
        $('#btn-simpan').val("tambah-pembicara");
        $('#tambahModal').modal('show');
        $('#formpembicara').trigger("reset");
        $('#modal-judul').html("Tambah Pembicara");
    });
});


//SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
//jika id = formPembicara panjangnya lebih dari 0 atau bisa dibilang terdapat data dalam form tersebut maka
//jalankan jquery validator terhadap setiap inputan dll dan eksekusi script ajax untuk simpan data
if ($("#formPembicara").length > 0) {
    $("#formPembicara").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-simpan').val();
            // Mengubah data menjadi objek agar file image bisa diinput kedalam database
            var formData = new FormData($('#formPembicara')[0]);
            $.ajax({
                data: formData, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                url: "/pembicara/store", //url simpan data
                type: "POST", //data tipe kita kirim berupa JSON
                contentType: false,
                processData: false,
                success: function(response) {
                    var oTable = $('#table-pembicara').dataTable(); //inialisasi datatable
                    oTable.fnDraw(false); //reset datatable
                    if (response.status == 400) {
                        $('#save_errorList').html("");
                        $('#save_errorList').removeClass('d-none');
                        $.each(response.errors, function(key, err_value) {
                            $('#save_errorList').append('<li>' + err_value +
                                '</li>');
                        });

                        $('#btn-simpan').text('Menyimpan..');
                    } else if (response.status == 200) {
                        $('#modalJudul').html("");
                        $('#formPembicara').find('input').val('');
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

// Function Edit pembicara
$(document).on('click', '.edit-pembicara', function(e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#editModal').modal('show');
    $('#titleEdit').html("Edit Data pembicara");

    $.ajax({
        type: "GET",
        url: "/pembicara/edit/" + id,
        success: function(response) {
            // console.log(response);
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
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
    $('.btn-close').find('input').val('');

});


// Function update data pembicara
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();

    var id = $('#id').val();

    // Mengubah data menjadi objek agar file image bisa diinput kedalam database
    var EditFormData = new FormData($('#formEdit')[0]);

    $.ajax({
        type: "POST",
        url: "/pembicara/update/" + id,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function(response) {
            // console.log(response);
            var oTable = $('#table-pembicara').dataTable(); //inialisasi datatable
            oTable.fnDraw(false); //reset datatable
            if (response.status == 400) {
                $('#modalJudulEdit').html("");
                $('#modalJudulEdit').removeClass('d-none');
                $.each(response.errors, function(key, err_value) {
                    $('#modalJudulEdit').append('<li>' + err_value +
                        '</li>');
                });

                $('#btn-update').text('Update');
            } else if (response.status == 404) {
                toastr.success(response.message);
            } else if (response.status == 200) {
                $('#modalJudulEdit').html("");
                toastr.success(response.message);

                $('#editModal').modal('hide');
            }
        },
        error: function(response) {
            $('#save_errorList').html("");
            // console.log('Error:', response);
        }
    });

});

// Function delete data pembicara
//jika klik class delete (yang ada pada tombol delete) maka tampilkan modal konfirmasi hapus maka
$('body').on('click', '.delete', function() {
    id = $(this).attr('id');
    $('#modalHapus').modal('show');
});
//jika tombol hapus pada modal konfirmasi di klik maka
$('#btn-hapus').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "/pembicara/delete/" + id, //eksekusi ajax ke url ini
        type: 'delete',
        beforeSend: function() {
            $('#btn-hapus').text('Hapus Data...'); //set text untuk tombol hapus
        },
        success: function(response) { //jika sukses
            setTimeout(function() {
                $('#modalHapus').modal('hide');
                var oTable = $('#table-pembicara').dataTable();
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