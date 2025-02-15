<x-app-layout :title="$title">
    @push('custom-css')
        <link href="{{ asset('assets') }}/vendor/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="{{ route('users.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        </div>
        <div>
            @if ($errors->any())
                <div class="alert alert-danger fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables {{ $title }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>NIP</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($users as $value)
        <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data {{ $title }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.update', $value->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukan Nama"
                                    value="{{ $value->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukan Email"
                                    value="{{ $value->email }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" placeholder="Masukan NIP"
                                    value="{{ $value->nip }}" placeholder="Masukan 18 digit NIP" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No HP</label>
                                <input type="text" name="nohp" class="form-control" placeholder="Masukan No HP"
                                    value="{{ $value->nohp }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="admin" {{ $value->role == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="staff_administrasi"
                                        {{ $value->role == 'staff_administrasi' ? 'selected' : '' }}>Staff Administrasi
                                    </option>
                                    <option value="guru" {{ $value->role == 'guru' ? 'selected' : '' }}>Guru
                                    </option>
                                    <option value="kepala_sekolah"
                                        {{ $value->role == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah
                                    </option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('custom-js')
        <script src="{{ asset('assets') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('user-management.data') }}',
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },
                        {
                            data: 'nohp',
                            name: 'nohp'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
