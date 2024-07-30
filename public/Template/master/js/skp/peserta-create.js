$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).ready(function () {
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
                        if (response.status == 400) {
                            $('#errorlist').html("");
                            $('#errorlist').addClass('class="alert alert-danger mb-3 alert-validation-msg" role="alert"');
                            $.each(response.errors, function(key, err_value) {
                                $('#errorlist').append('<div class="alert-body d-flex align-items-center"><i data-feather="info" class="me-50"></i><span>' + err_value + '</span></div>');
                            });

                            $('#btn-simpan').text('Mengirim..');
                        
                        // console.log(response.status);
                        } else if (response.status == 409) {
                            setTimeout(function(){ // wait for 2 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 2000); 
                            $('#formPeserta').find('input').val('');
                            toastr.error(response.errors);
                        } else if (response.status == 200) {
                            setTimeout(function(){ // wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 2000); 
                            $('#modalJudul').html("");
                            $('#formPeserta').find('input').val('');
                            toastr.success(response.message);
                        }
                    },
                    error: function(jqXHR, exception) {
                        // console.log(response.errors);
                        alert(jqXHR.responseText);
                        // $('#btn-simpan').html('Kirim');
                    }
                });
            }
        })
    }
});