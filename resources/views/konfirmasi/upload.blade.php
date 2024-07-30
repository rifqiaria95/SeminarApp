@extends('master.auth.app')
@section('content')

    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="#" class="app-brand-link gap-2">
                                <img src="{{ asset('Template/master/img/menarasyariah-logo-2.png') }}" alt="" style="width: 100%">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2 text-center">Menara Syariah & INCEIF University Symposium (MSIUS) 2024</h4>
                        <p class="mb-4 text-center">Sistem Informasi Seminar Online MSIUS</p>
                        <ul class="alert alert-warning d-none" id="save_errorList"></ul>
                        <div class="divider">
                            <div class="divider-text">Informasi Peserta</div>
                        </div>
                        <div class="col-lg-12 mb-1">
                            <!-- Menampilkan data peserta -->
                            <div class="mb-3">
                                <h6 class="mb-1">Kode Registrasi:</h6>
                                <p id="kode_registrasi">{{ $peserta->kode_registrasi }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Nama Lengkap:</h6>
                                <p id="nama_lengkap">{{ $peserta->nama_lengkap }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">No. Telepon:</h6>
                                <p id="phone">{{ $peserta->phone }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Email:</h6>
                                <p id="email">{{ $peserta->email }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Company:</h6>
                                <p id="company">{{ $peserta->company }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Judul Seminar:</h6>
                                <p id="judul">{{ $peserta->data_seminar->judul }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Biaya Seminar:</h6>
                                <p id="harga">{{ $peserta->data_seminar->harga }}</p>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Upload Bukti Pembayaran</div>
                            </div>
                            <!-- Form untuk mengunggah bukti pembayaran -->
                            <form id="formKfrBayar" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $peserta->id }}">
                                <input type="hidden" id="status_pembayaran" name="status_pembayaran" value="{{ $konfirmasi->status_pembayaran ?? 0 }}">
                                <input type="hidden" id="peserta_id" name="peserta_id" value="{{ $peserta->id }}">
                                <div class="mb-3">
                                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="form-control" placeholder="Upload Bukti Bayar">
                                </div>
                                <button type="submit" class="btn btn-primary me-2 mt-2" id="btn-simpan">Simpan</button>
                            </form>                    
                        </div>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
    <!-- / Content -->

@endsection

@section('script')
    <script src="{{ asset('Template/master/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
    <script src="{{ asset('Template/master/js/skp/konfirmasi-upload.js') }}"></script>
@endsection