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
    $('#table-seminar').DataTable({
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
            text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah Seminar</span>',
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
            url: "/seminar",
            type: 'GET'
        },
        columns: [{
                data: 'judul',
                name: 'judul'
            },
            {
                data: 'link',
                name: 'link'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'harga',
                name: 'harga'
            },
            {
                data: 'lampiran',
                name: 'lampiran'
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


// Function untuk tombol tambah seminar dan tampilkan modal
$(document).ready(function() {
    // $.noConflict();
    $('.btn_tambah').click(function() {
        // console.log($('#btn_tambah'));
        $('#btn-simpan').val("tambah-seminar");
        $('#tambahModal').modal('show');
        $('#formSeminar').trigger("reset");
        $('#modal-judul').html("Tambah Seminar");
        $('#selectPembicara').select2({
            dropdownParent: $('#tambahModal')
        });
    });
});


//SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
//jika id = formSeminar panjangnya lebih dari 0 atau bisa dibilang terdapat data dalam form tersebut maka
//jalankan jquery validator terhadap setiap inputan dll dan eksekusi script ajax untuk simpan data
if ($("#formSeminar").length > 0) {
    $("#formSeminar").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-simpan').val();
            // Mengubah data menjadi objek agar file image bisa diinput kedalam database
            var formData = new FormData($('#formSeminar')[0]);

            $.ajax({
                data: formData, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                url: "/seminar/store", //url simpan data
                type: "POST", //data tipe kita kirim berupa JSON
                contentType: false,
                processData: false,
                success: function(response) {
                    var oTable = $('#table-seminar').dataTable(); //inisialisasi datatable
                    oTable.fnDraw(false); //reset datatable
                    if (response.status == 400) {
                        $('#save_errorList').html("");
                        $('#save_errorList').removeClass('d-none');
                        $.each(response.errors, function(key, err_value) {
                            $('#save_errorList').append('<li>' + err_value + '</li>');
                        });
                        $('#btn-simpan').text('Menyimpan..');
                    } else if (response.status == 200) {
                        $('#modalJudul').html("");
                        $('#formSeminar').find('input').val('');
                        $('#formSeminar').find('select').val(null).trigger('change'); // Reset select2
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


// Function Edit Seminar
$(document).on('click', '.edit-seminar', function(e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#editModal').modal('show');
    $('#titleEdit').html("Edit Data Seminar");
    $('.select2').select2({
        dropdownParent: $('#editModal')
    });

    $.ajax({
        dataType: "json",
        method: "GET",
        url: "/seminar/edit/" + id,
        success: function(response) {
            // console.log(response);
            if (response.status == 404) {
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#editModal').modal('hide');
            } else {
                // Mengisi form dengan data seminar
                $('#id').val(id);
                $('#judul').val(response.judul);
                $('#link').val(response.link);
                $('#tanggal').val(response.tanggal);
                $('#harga').val(response.harga);
                $('#lampiran').val(response.lampiran);
    
                // Kosongkan pilihan pembicara sebelumnya
                $('#pembicara_id').empty();
    
                // Tambahkan opsi pembicara ke select
                $.each(response.pembicara, function(key, pembicara) {
                    $('#pembicara_id').append('<option value="' + pembicara.id + '">' + pembicara.nama_lengkap + '</option>');
                });
    
                // Mengatur nilai terpilih
                $('#pembicara_id').val(response.pembicara_id).trigger('change');
            }
        },
        error: function(response) {
            // console.log(response);
        }
    });
});

// Menghapus nilai input saat modal ditutup
$('#editModal').on('hidden.bs.modal', function () {
    $(this).find('input, textarea').val('');
    $(this).find('select').val(null).trigger('change');
    $('#success_message').removeClass('alert alert-success').text('');
});


$('#pembicara_id').select2({
    dropdownParent: $('#editModal'),
    // Pilihan tambahan jika diperlukan
});

// Event handler untuk menghapus pembicara dari database
$('#pembicara_id').on('select2:unselect', function(e) {
    var pembicara_id = e.params.data.id; // ID pembicara yang dihapus

    // Kirim permintaan AJAX untuk menghapus hubungan pembicara dari seminar
    $.ajax({
        dataType: "json",
        method: "POST", // Sesuaikan dengan metode yang digunakan
        url: "/seminar/remove-pembicara", // Sesuaikan dengan endpoint yang tepat
        data: {
            seminar_id: $('#id').val(), // ID seminar
            pembicara_id: pembicara_id // ID pembicara yang dihapus
        },
        success: function(response) {
            // console.log(response);
            // Tambahkan logika atau feedback lainnya jika diperlukan
        },
        error: function(response) {
            // console.log(response);
            // Tambahkan penanganan error jika diperlukan
        }
    });
});


// Function update data seminar
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    var id = $('#id').val();

    // Mengubah data menjadi objek agar file image bisa diinput kedalam database
    var EditFormData = new FormData($('#formEdit')[0]);

    $.ajax({
        type: "POST",
        url: "/seminar/update/" + id,
        data: EditFormData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            var oTable = $('#table-seminar').dataTable(); //inialisasi datatable
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
            console.log('Error:', response);
        }
    });

});


// Function delete data seminar
//jika klik class delete (yang ada pada tombol delete) maka tampilkan modal konfirmasi hapus maka
$('body').on('click', '.delete', function() {
    id = $(this).attr('id');
    $('#modalHapus').modal('show');
});
//jika tombol hapus pada modal konfirmasi di klik maka
$('#btn-hapus').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "/seminar/delete/" + id, //eksekusi ajax ke url ini
        type: 'delete',
        beforeSend: function() {
            $('#btn-hapus').text('Hapus Data...'); //set text untuk tombol hapus
        },
        success: function(response) { //jika sukses
            setTimeout(function() {
                $('#modalHapus').modal('hide');
                var oTable = $('#table-seminar').dataTable();
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

$(document).ready(function () {
    $('#inputHarga').on('input', function(e) {
        // Remove non-numeric characters except for dots
        let value = $(this).val().replace(/[^0-9]/g, '');
        
        // Format the number with dots every 3 digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        
        // Add Rp in front of the number
        $(this).val('Rp ' + value);
    });

    // Make sure the value is formatted correctly before sending to the server
    $('#formSeminar').on('submit', function(e) {
        let hargaField = $('#inputHarga');
        let hargaValue = hargaField.val(); // Keep Rp and dots
        hargaField.val(hargaValue);
    });
});