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
                  {{-- <span class="app-brand-text demo text-body fw-bold ms-1">Vuexy</span> --}}
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1 pt-2 text-center">Adventure starts here 🚀</h4>
              <p class="mb-4 text-center">Make your app management easy and fun!</p>

              <form id="formPeserta" class="mb-3" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                  <input
                    type="text"
                    class="form-control"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    placeholder="Masukkan Nama Lengkap"
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">No. Telepon</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan No. Telepon" />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" />
                </div>
                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Masukkan Company" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="multicol-username">Judul Seminar</label>
                    <select class="select2 form-select" id="selectSeminar" name="data_seminar_id" required>
                        <option selected disabled>Pilih Judul Seminar</option>
                        @foreach ($seminar as $sm)
                        <option value="{{ $sm->id }}">{{ $sm->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-floating col-md-6 d-none">
                    <fieldset class="form-group">
                        <select class="select2 form-select" name="status_pembayaran" id="selectPembayaran" required>
                            <option selected value="0">Pending</option>
                            <option value="1">Lunas</option>
                        </select>
                    </fieldset>
                </div>
                <button type="submit" value="create" id="btn-simpan" class="btn btn-primary d-grid w-100">Daftar</button>
              </form>
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
    <script src="{{ asset('Template/master/js/skp/peserta-create.js') }}"></script>
@endsection