<x-app-layout :title="$title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('students.update', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $student->name) }}"
                                    placeholder="Masukan nama siswa" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                    id="nis" name="nis" value="{{ old('nis', $student->nis) }}"
                                    placeholder="Masukan NIS siswa" required>
                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                    id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}"
                                    placeholder="Masukan NISN siswa" required>
                                @error('nisn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                    name="gender" required>
                                    <option value="Laki-laki" {{ $student->gender == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="Perempuan" {{ $student->gender == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="religion">Agama</label>
                                <select class="form-control @error('religion') is-invalid @enderror" id="religion"
                                    name="religion" required>
                                    <option disabled selected>Pilih Agama</option>
                                    <option value="Islam"
                                        {{ old('religion', $student->religion) == 'Islam' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="Kristen"
                                        {{ old('religion', $student->religion) == 'Kristen' ? 'selected' : '' }}>
                                        Kristen</option>
                                    <option value="Katolik"
                                        {{ old('religion', $student->religion) == 'Katolik' ? 'selected' : '' }}>
                                        Katolik</option>
                                    <option value="Hindu"
                                        {{ old('religion', $student->religion) == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Buddha"
                                        {{ old('religion', $student->religion) == 'Buddha' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="Konghucu"
                                        {{ old('religion', $student->religion) == 'Konghucu' ? 'selected' : '' }}>
                                        Konghucu</option>
                                </select>
                                @error('religion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="class_id">Kelas</label>
                                <select class="form-control @error('class_id') is-invalid @enderror" id="class_id"
                                    name="class_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('students') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
