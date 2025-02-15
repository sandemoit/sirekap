<x-app-layout :title="$title">
    @push('custom-css')
        <link href="{{ asset('assets') }}/vendor/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#addModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
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
                            <table class="table table-bordered" id="classTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Kelas</th>
                                        <th>Wali Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->teacher ? $value->teacher->name : 'Tidak Ada Guru' }}</td>
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#editModal{{ $value->id }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{ route('class.destroy', $value->id) }}"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                    class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($classes as $value)
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
                        <form action="{{ route('class.update', $value->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" name="class_name" class="form-control"
                                    placeholder="Masukan Nama Kelas" value="{{ $value->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Wali Kelas</label>
                                <select name="teacher_id" class="form-control">
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ $teacher->id == $value->teacher_id ? 'selected' : '' }}>
                                            {{ $teacher->name }}</option>
                                    @endforeach
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $title }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('class.add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="class_name" class="form-control"
                                placeholder="Masukan Nama Kelas" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wali Kelas</label>
                            <select name="teacher_id" class="form-control">
                                <option selected disabled>Pilih Wali Kelas</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
        <script src="{{ asset('assets') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>

        <script>
            @(document).ready(function() {
                $('#classTable').DataTable()
            })
        </script>
    @endpush
</x-app-layout>
