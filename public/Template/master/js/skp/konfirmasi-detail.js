$(document).ready(function() {
    $('#sendQrCodeBtn').on('click', function() {
        // Ambil nomor telepon dari field
        var phone = $('#phone').text().trim();
        // Ganti semua spasi dengan string kosong
        phone = phone.replace(/\s/g, '');
        // Ambil tanggal seminar dan URL QR Code dari variabel JavaScript
        var message = `KONFIRMASI PEMBAYARAN\n\n` +
                      `Bukti Pembayaran anda sudah kami approval, anda sudah menjadi peserta Menara Syariah & INCEIF Symposium (MSIUS) 2024.\n\n` +
                      `Tunjukan QR Code atau pesan ini pada tanggal ${seminarDate} di booth registrasi ulang Gedung Menara Syariah Lantai 10, PIK2 - Banten.\n\n` +
                      `QR Code: ${qrCodeUrl}\n\n` +
                      `Terima Kasih atas kerjasama dan partisipasi anda.\n\n` +
                      `Salam,\n\n` +
                      `Panitia\n` +
                      `MSIUS 2024`;
        // Buat URL WhatsApp
        var whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
        // Arahkan pengguna ke URL WhatsApp
        window.open(whatsappUrl, '_blank');
    });
});
