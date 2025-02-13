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
                        <span>All Users</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2">{{ totalUser() }}</h4>
                        </div>
                        <span>Diperbarui {{ $user[0]->created_at->diffForhumans() }}</span>
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
                        <span>Active Users</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2">{{ totalActiveUser() }}</h4>
                        </div>
                        <span>Diperbarui {{ $user[0]->updated_at->diffForhumans() }}</span>
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
                        <span>Inactive Users</span>
                        <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2">{{ totalInactiveUser() }}</h4>
                        </div>
                        <span>Diperbarui {{ $user[0]->updated_at->diffForhumans() }}</span>
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
                    <table id="table-user" class="datatables-users table border-top">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </table>
                </div>
            </div>
            <!-- Modal Tambah Seminar -->
            <div class="modal fade text-start" id="tambahModal" tabindex="-1" aria-labelledby="myModalLabel18" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-judul">Tambah Seminar</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formUser" class="card-body source-item" enctype="multipart/form-data">
                            @csrf
                            <ul class="alert alert-warning d-none" id="save_errorList"></ul>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <select class="select2 form-select selectRole" name="role" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="owner">Owner</option>
                                        <option value="admin">Admin</option>
                                        <option value="karyawan">Karyawan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select class="select2 form-select selectStatus" name="status_user" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-simpan" value="create">Simpan</button>
                                <button type="reset" class="btn btn-label-secondary mx-3">Cancel</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
            {{-- End Modal Tambah Seminar --}}

            <!-- Modal Edit user -->
            <div class="modal fade text-start" id="editModal" tabindex="-1" aria-labelledby="myModalLabel18" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="titleEdit"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEdit" name="formEdit" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <ul class="alert alert-warning d-none" id="modalJudulEdit"></ul>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" id="name" name="name" class="name form-control" value="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="email form-control" value="" required>
                                    </div>
                                    <div class="form-floating col-md-6">
                                        <fieldset class="form-group">
                                            <label class="form-label">Role</label>
                                            <select class="select2 form-select" name="role" id="role" required>
                                                <option>Pilih Role</option>
                                                <option value="owner">Owner</option>
                                                <option value="admin">Admin</option>
                                                <option value="karyawan">Karyawan</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="form-floating col-md-6">
                                        <fieldset class="form-group">
                                            <label class="form-label">Status</label>
                                            <select class="select2 form-select" name="status_user" id="status_user" required>
                                                <option>Pilih Status</option>
                                                <option value="0">Inactive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Avatar</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-update" value="create">Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Modal Tambah User --}}

            <!-- Modal Konfirmasi Delete -->
            <div class="modal fade" tabindex="-1" role="dialog" id="modalHapus" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">PERHATIAN</h5>
                        </div>
                        <div class="modal-body">
                            <p><b>Jika menghapus user maka</b></p>
                            <p>*data user tersebut hilang selamanya, apakah anda yakin?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="btn-hapus" data-target="#btn-hapus" class="btn btn-danger tambah_data" value="add">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Modal Konfirmasi Delete --}}
            </div>
        </div>
        <!-- / Content -->
@endsection

@section ('script')
    <script src="{{ asset('Template/master/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
    <!-- Page JS -->
    <script src="{{ asset('Template/master/js/tables-datatables-basic.js') }}"></script>
    <script src="{{ asset('Template/master/js/skp/user.js') }}"></script>

    <script>
        var userRole = {!! json_encode($userRole) !!};
    </script>
@endsection