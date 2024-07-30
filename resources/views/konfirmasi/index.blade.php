@extends('master.template')
@section('content')

        <!-- Content wrapper -->
        <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Peserta</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2"></h4>
                        </div>
                        <span>Diperbarui </span>
                    </div>
                    <span class="badge bg-label-primary rounded p-2">
                        <i class="ti ti-user ti-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Sudah Lunas</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2">4,567</h4>
                        <span class="text-success">(+18%)</span>
                        </div>
                        <span>Last week analytics </span>
                    </div>
                    <span class="badge bg-label-danger rounded p-2">
                        <i class="ti ti-user-plus ti-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Belum Dibayar</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2"></h4>
                        </div>
                        <span>Diperbarui </span>
                    </div>
                    <span class="badge bg-label-success rounded p-2">
                        <i class="ti ti-user-check ti-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>PO Pending</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2"></h4>
                        </div>
                        <span>Diperbarui </span>
                    </div>
                    <span class="badge bg-label-warning rounded p-2">
                        <i class="ti ti-user-exclamation ti-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- Users List Table -->
            <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-3">Search Filter</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table id="table-konfirmasi" class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th>Kode Registrasi</th>
                        <th>Nama Lengkap</th>
                        <th>No. Telepon</th>
                        <th>Judul Seminar</th>
                        <th>Bukti Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                </table>
            </div>

            <!-- Modal Edit peserta -->
            <div class="modal fade text-start" id="editModal" tabindex="-1" aria-labelledby="myModalLabel18" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-judul">Konfirmasi Pembayaran</h4>
                            <ul class="alert alert-warning d-none" id="modalJudulEdit"></ul>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEdit" name="formEdit" class="card-body source-item" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <ul class="save_errorList"></ul>
                            <div class="row g-3">
                                <div class="form-floating col-lg-12">
                                    <fieldset class="form-group">
                                        <label class="form-label">Status Pembayaran</label>
                                        <select class="select2 form-select" name="status_pembayaran" id="status_pembayaran" required>
                                            <option selected disabled>Pilih Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Lunas</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-update" value="create">Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Edit Purchase --}}

            <!-- Modal Konfirmasi Delete -->
            <div class="modal fade" tabindex="-1" role="dialog" id="modalHapus" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">PERHATIAN!</h5>
                        </div>
                        <div class="modal-body">
                            <p><b>Jika menghapus peserta maka</b></p>
                            <p>*data peserta akan hilang selamanya, apakah anda yakin?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="btn-hapus" data-target="#btn-hapus" class="btn btn-danger tambah_data" value="add">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- {{-- End Modal Konfirmasi Delete --}}
            </div>
        </div>
        <!-- / Content -->
@endsection

@section ('script')
    <script src="{{ asset('Template/master/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
    <script src="{{ asset('Template/master/js/tables-datatables-basic.js') }}"></script>
    <script src="{{ asset('Template/master/js/skp/konfirmasi.js') }}"></script>

    {{-- <script>
        var userRole = {!! json_encode($userRole) !!};
    </script> --}}
@endsection