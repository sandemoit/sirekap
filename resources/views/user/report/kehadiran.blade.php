<x-app-layout :title="$title">
    <div class="container">
        <div class="card">
            <div class="card-header">
                Rekap Kehadiran Siswa
            </div>

            <div class="card-body">

                <form action="{{ route('laporan.kehadiran.export') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="kelas">Pilih Kelas:</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="all">Semua Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="bulan">Pilih Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control">
                                @for ($i = date('Y'); $i >= 2023; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger mt-3">Export PDF</button>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                Rekap Persentase Kehadiran Siswa
            </div>

            <div class="card-body">
                <form action="{{ route('laporan.kehadiran.export.persen') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="kelas">Pilih Kelas:</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="all">Semua Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="bulan">Pilih Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control">
                                @for ($i = date('Y'); $i >= 2023; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger mt-3">Export PDF</button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
