<x-app-layout :title="$title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('competition.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Judul Kompetisi</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Masukan judul kompetisi" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                    cols="30" rows="10" placeholder="Masukan deskripsi" required>{{ old('description') }}</textarea>
                                <span class="text-muted">*225 Karakter</span>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Siswa</label>
                                <select name="student_id" id="student_id"
                                    class="form-control @error('student_id') is-invalid @enderror">
                                    <option selected disabled>Pilih siswa</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Kelas</label>
                                <select name="class_id" id="class_id"
                                    class="form-control @error('class_id') is-invalid @enderror">
                                    <option selected disabled>Pilih kelas</option>
                                    @foreach ($class as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"required>
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" required>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('competition') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
