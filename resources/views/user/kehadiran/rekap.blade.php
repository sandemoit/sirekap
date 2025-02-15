<x-app-layout :title="$title">
    @push('custom-css')
        <link href="{{ asset('assets') }}/vendor/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
            </div>

            <div class="card-body">
                <!-- Filter Kelas & Tanggal -->
                <!-- Form Filter -->
                <form id="filterForm" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tahun">Tahun Ajaran</label>
                            <select name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i . '/' . ($i + 1) }}"
                                        {{ request('tahun_ajaran') == $i . '/' . ($i + 1) ? 'selected' : '' }}>
                                        {{ $i . '/' . ($i + 1) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="start">Tanggal Mulai</label>
                            <input type="date" id="start" name="start" class="form-control"
                                value="{{ request('start') ?? date('Y-m-01') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="end">Tanggal Akhir</label>
                            <input type="date" id="end" name="end" class="form-control"
                                value="{{ request('end') ?? date('Y-m-d') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="kelas">Semester</label>
                            <select id="semester" name="semester" class="form-control">
                                <option value="1" {{ request('semester') == 1 ? 'selected' : '' }}>Semester 1
                                </option>
                                <option value="2" {{ request('semester') == 2 ? 'selected' : '' }}>Semester 2
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="kelas">Kelas</label>
                            <select id="kelas" name="kelas" class="form-control">
                                <option value="all">Semua</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}"
                                        {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col md-2" style="margin-top: 30px">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                Tampilkan</button>
                        </div>
                    </div>
                </form>

                @php
                    $startDate = request('start') ? date('d', strtotime(request('start'))) : 1;
                    $endDate = request('end') ? date('d', strtotime(request('end'))) : date('d');
                @endphp
                <!-- Tabel Responsif -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">NISN</th>
                                <th rowspan="2" class="align-middle">Name</th>
                                <th rowspan="2" class="align-middle">Kelas</th>
                                <th colspan="{{ $endDate - $startDate + 1 }}">Tanggal</th>
                                <th colspan="5">Total</th>
                            </tr>
                            <tr>
                                @for ($i = $startDate; $i <= $endDate; $i++)
                                    <th>{{ $i }}</th>
                                @endfor
                                <th class="bg-success">H</th>
                                <th class="bg-warning">T</th>
                                <th class="bg-primary">S</th>
                                <th class="bg-info">I</th>
                                <th class="bg-danger">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $row)
                                <tr>
                                    <td>{{ $row['nisn'] }}</td>
                                    <td>{{ $row['name'] }}</td>
                                    <td>{{ $row['kelas'] }}</td>
                                    @foreach ($row['rekap'] as $status)
                                        <td {!! $status !!}</td>
                                    @endforeach
                                    <td class="text-center">{{ $row['summary']['H'] }}</td>
                                    <td class="text-center">{{ $row['summary']['T'] }}</td>
                                    <td class="text-center">{{ $row['summary']['S'] }}</td>
                                    <td class="text-center">{{ $row['summary']['I'] }}</td>
                                    <td class="text-center">{{ $row['summary']['A'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $endDate - $startDate + 9 }}" class="text-center">Data tidak
                                        ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
