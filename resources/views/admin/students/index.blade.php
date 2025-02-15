<x-app-layout :title="$title">
    @push('custom-css')
        <link href="{{ asset('assets') }}/vendor/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="{{ route('students.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables {{ $title }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="studentsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Wali Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
        <script src="{{ asset('assets') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/datatables/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#studentsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('students.data') }}',
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'nis',
                            name: 'nis'
                        },
                        {
                            data: 'nisn',
                            name: 'nisn'
                        },
                        {
                            data: 'wali_kelas',
                            name: 'wali_kelas'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'religion',
                            name: 'religion'
                        },
                        {
                            data: 'class',
                            name: 'class'
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
