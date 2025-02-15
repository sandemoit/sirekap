<x-app-layout :title="$title">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ $title }}</div>
            <div class="p-3">
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
            <div class="card-body">
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control" required>
                                <option disabled selected>Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal Penilaian</label>
                            <input type="date" name="tanggal" class="form-control" required
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Pilih Mata Pelajaran</label>
                            <select name="mapel_id" class="form-control" required>
                                <option selected disabled>Pilih Mata Pelajaran</option>
                                @foreach ($mapel as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label>Nama Penilaian</label>
                            <input type="text" name="nama_penilaian" class="form-control" required
                                placeholder="Misal: Ulangan Harian 1">
                        </div>
                    </div>

                    <div id="siswa-list" class="mt-4">
                        <!-- Daftar siswa akan dimuat di sini -->
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Penilaian</button>
                </form>
            </div>
        </div>
    </div>

    @push('custom-js')
        <script>
            $(document).ready(function() {
                $('#kelas_id').change(function() {
                    var kelas_id = $(this).val();
                    if (kelas_id) {
                        $('#siswa-list').html(
                            '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>'
                        );
                        $.ajax({
                            url: '{{ route('penilaian.get-siswa') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                kelas_id: kelas_id
                            },
                            success: function(data) {
                                var html = '';
                                if (data.length === 0) {
                                    html =
                                        '<div class="alert alert-warning text-center">Tidak ada siswa yang ditemukan untuk kelas ini.</div>';
                                } else {
                                    html = '<div class="table-responsive"><table class="table">';
                                    html +=
                                        '<thead><tr><th>Nama Siswa</th><th>Nilai</th></tr></thead><tbody>';

                                    data.forEach(function(siswa) {
                                        html += '<tr>';
                                        html += '<td>' + siswa.name + '</td>';
                                        html +=
                                            '<td><input type="number" placeholder="Masukan Nilai" name="nilai[' +
                                            siswa.id +
                                            ']" class="form-control" min="0" max="100" required></td>';
                                        html += '</tr>';
                                    });

                                    html += '</tbody></table></div>';
                                }
                                $('#siswa-list').html(html);
                            }
                        });
                    } else {
                        $('#siswa-list').html('');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
