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
                        <span>Total PO</span>
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
                        <span>Paid Users</span>
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
                        <span>PO Selesai</span>
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
                <table id="table-pembicara" class="datatables-users table border-top">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                </table>
            </div>
            
            <!-- Modal Tambah Pembicara -->
            <div class="modal fade text-start" id="tambahModal" tabindex="-1" aria-labelledby="myModalLabel18" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-judul">Tambah Purchase Order</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formPembicara" class="card-body source-item" enctype="multipart/form-data">
                            @csrf
                            <ul id="save_errorList"></ul>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Nama Pembicara</label>
                                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Pembicara" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">No. Telepon</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Masukkan No. Telepon" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email Pembicara" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Company</label>
                                    <input type="text" name="company" class="form-control" placeholder="Masukkan Company" />
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-simpan" value="create">Simpan
                                </button>
                                <button type="reset" class="btn btn-label-secondary mx-3">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Tambah PO --}}

            <!-- Modal Edit purchase -->
            <div class="modal fade text-start" id="editModal" tabindex="-1" aria-labelledby="myModalLabel18" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-judul">Edit Pembicara</h4>
                            <ul class="alert alert-warning d-none" id="modalJudulEdit"></ul>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEdit" name="formEdit" class="card-body source-item" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <ul id="save_errorList"></ul>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Nama Pembicara</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="" class="form-control" placeholder="Masukkan Nama Pembicara" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">No. Telepon</label>
                                    <input type="text" id="phone" name="phone" value="" class="form-control" placeholder="Masukkan No. Telepon" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Email</label>
                                    <input type="email" id="email" name="email" value="" class="form-control" placeholder="Masukkan Email Pembicara" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="multicol-username">Company</label>
                                    <input type="text" id="company" name="company" value="" class="form-control" placeholder="Masukkan Company" />
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-update" value="create">Simpan
                                </button>
                                <button type="reset" class="btn btn-label-secondary mx-3">Cancel</button>
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
                            <h5 class="modal-title">PERHATIAN</h5>
                        </div>
                        <div class="modal-body">
                            <p><b>Jika menghapus pembicara maka</b></p>
                            <p>*data pembicara tersebut hilang selamanya, apakah anda yakin?</p>
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
    <script src="{{ asset('Template/master/js/skp/pembicara.js') }}"></script>

    {{-- <script>
        var items = {!! json_encode($item) !!};
    </script> --}}
@endsection