@extends('master.template')

@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Data Seminar /</span> Konfirmasi Pembayaran
      </h4>
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-4">
            <li class="nav-item">
              <a class="nav-link" href="pages-account-settings-account.html">
                <i class="ti-xs ti ti-users me-1"></i> Informasi Pembayaran & Data Peserta
              </a>
            </li>
          </ul>
          <div class="card mb-4">
            <!-- Current Plan -->
            <h5 class="card-header">Informasi Peserta</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <!-- Info Peserta -->
                        <div class="mb-3">
                            <h6 class="mb-1">Kode Registrasi</h6>
                            <p>{{ $peserta->kode_registrasi }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">Nama Lengkap</h6>
                            <p>{{ $peserta->nama_lengkap }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">No. Telepon</h6>
                            <p id="phone">{{ $peserta->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">Email</h6>
                            <p>{{ $peserta->email }}</p>
                        </div>
                        <h5 class="mb-4 mt-4">Informasi Seminar</h5>
                        <div class="mb-3">
                            <h6 class="mb-1">Judul Seminar</h6>
                            <p>{{ $peserta->data_seminar->judul }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">Biaya Seminar</h6>
                            <p>{{ $peserta->data_seminar->harga }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">Bukti Pembayaran</h6>
                            <p>
                                @if ($peserta->konfirmasi->bukti_pembayaran !== '-')
                                    <a href="{{ asset('storage/' . $peserta->konfirmasi->bukti_pembayaran) }}" target="_blank">Lihat Bukti Pembayaran</a>
                                @else
                                    Belum ada bukti pembayaran
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="divider divider-vertical align-items-end"></div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <!-- Status Pembayaran dan QR Code -->
                        <div class="alert {{ $peserta->konfirmasi->status_pembayaran === 0 ? 'alert-warning' : 'alert-success' }} mb-3" role="alert">
                            <h5 class="alert-heading mb-1">Status Pembayaran:</h5>
                            <span>
                                {{ $peserta->konfirmasi->status_pembayaran === 0 ? 'Menunggu Pembayaran' : 'Lunas' }}
                            </span>
                        </div>
                        <div class="plan-statistics">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Jadwal Seminar</h6>
                                <h6 class="mb-2">{{ $peserta->data_seminar->tanggal }}</h6>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mt-1 mb-0">6 days remaining until your plan requires update</p>
                        </div>
                        @if($peserta->konfirmasi->status_pembayaran === 1)
                            <div class="pt-4 qr-code d-flex flex-column align-items-center mt-4">
                                <img id="qrCodeImage" src="{{ asset('qrcodes/' . Str::slug($peserta->nama_lengkap) . '.png') }}" alt="QR Code" style="width: 30%;">
                                <a href="{{ asset('qrcodes/' . Str::slug($peserta->nama_lengkap) . '.png') }}" download="QR_Code_{{ Str::slug($peserta->nama_lengkap) }}.png" class="btn btn-secondary btn-sm mt-4">
                                    Download QR Code
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 text-center mt-3">
                        @if($peserta->konfirmasi->status_pembayaran === 1)
                            <button class="btn btn-dark w-100 mt-2" id="sendQrCodeBtn">
                                Kirim QR Code
                            </button>
                        @endif
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
@endsection

@section('script')
  <script src="{{ asset('Template/master/vendor/libs/select2/select2.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
  <!-- Page JS -->
  <script src="{{ asset('Template/master/js/tables-datatables-basic.js') }}"></script>
  <script src="{{ asset('Template/master/js/skp/konfirmasi-detail.js') }}"></script>

  <script type="text/javascript">
      var seminarDate = @json($peserta->data_seminar->tanggal);
      var qrCodeUrl = @json(asset('qrcodes/' . Str::slug($peserta->nama_lengkap) . '.png'));
  </script>
@endsection
