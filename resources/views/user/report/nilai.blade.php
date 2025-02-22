<x-app-layout :title="$title">
    <div class="container">
        <h2 class="text-center">Rekap Nilai Siswa</h2>
        <form action="{{ route('laporan.nilai.export') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label>Pilih Kelas:</label>
                    <select name="kelas" class="form-control">
                        <option value="">Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
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
            <br>
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>
</x-app-layout>
