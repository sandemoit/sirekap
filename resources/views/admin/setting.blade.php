<x-app-layout :title="$title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Identitas Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.identitas') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror"
                                    id="nama_sekolah" name="nama_sekolah"
                                    value="{{ old('nama_sekolah', $setting['nama_sekolah']->value ?? '') }}"
                                    placeholder="Masukan nama sekolah" required>
                                @error('nama_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="npsn">NPSN (Nomor Pokok Sekolah Nasional)</label>
                                <input type="text" class="form-control @error('npsn') is-invalid @enderror"
                                    id="npsn" name="npsn"
                                    value="{{ old('npsn', $setting['npsn']->value ?? '') }}" placeholder="Masukan NPSN"
                                    required>
                                @error('npsn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="akreditasi">Akreditasi</label>
                                <input type="text" class="form-control @error('akreditasi') is-invalid @enderror"
                                    id="akreditasi" name="akreditasi"
                                    value="{{ old('akreditasi', $setting['akreditasi']->value ?? '') }}"
                                    placeholder="Masukan Akreditasi" required>
                                @error('akreditasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_sekolah">Alamat Sekolah</label>
                                <input type="text" class="form-control @error('alamat_sekolah') is-invalid @enderror"
                                    id="alamat_sekolah" name="alamat_sekolah"
                                    value="{{ old('alamat_sekolah', $setting['alamat_sekolah']->value ?? '') }}"
                                    placeholder="Masukan Alamat Sekolah" required>
                                @error('alamat_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telpon">Telepon/Fax</label>
                                <input type="text" class="form-control @error('telpon') is-invalid @enderror"
                                    id="telpon" name="telpon"
                                    value="{{ old('telpon', $setting['telpon']->value ?? '') }}"
                                    placeholder="Masukan Telepon/Fax" required>
                                @error('telpon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email Resmi</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email', $setting['email']->value ?? '') }}"
                                    placeholder="Masukan email Resmi" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="website">Website Resmi</label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror"
                                    id="website" name="website"
                                    value="{{ old('website', $setting['website']->value ?? '') }}"
                                    placeholder="Masukan Website Resmi" required>
                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kepala Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.kepala_sekolah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama_kepsek">Nama Kepala</label>
                                <input type="text" class="form-control @error('nama_kepsek') is-invalid @enderror"
                                    id="nama_kepsek" name="nama_kepsek"
                                    value="{{ old('nama_kepsek', $setting['nama_kepsek']->value ?? '') }}"
                                    placeholder="Masukan nama kepala sekolah" required>
                                @error('nama_kepsek')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nip_kepsek">NIP Kepala Sekolah</label>
                                <input type="text" class="form-control @error('nip_kepsek') is-invalid @enderror"
                                    id="nip_kepsek" name="nip_kepsek"
                                    value="{{ old('nip_kepsek', $setting['nip_kepsek']->value ?? '') }}"
                                    placeholder="Masukan NIP Kepala Sekolah" required>
                                @error('nip_kepsek')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="periode_jabatan">Periode Jabatan</label>
                                <input type="text"
                                    class="form-control @error('periode_jabatan') is-invalid @enderror"
                                    id="periode_jabatan" name="periode_jabatan"
                                    value="{{ old('periode_jabatan', $setting['periode_jabatan']->value ?? '') }}"
                                    placeholder="Masukan Periode Jabatan" required>
                                @error('periode_jabatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="foto_kepsek">Foto Kepala Sekolah</label>
                                <input type="file" class="form-control @error('foto_kepsek') is-invalid @enderror"
                                    id="foto_kepsek" name="foto_kepsek" value="{{ old('foto_kepsek') }}"
                                    placeholder="Masukan Periode Jabatan" required>
                                @error('foto_kepsek')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kata_sambutan">Kata Sambutan KepSek</label>
                                <textarea class="form-control @error('kata_sambutan') is-invalid @enderror" id="kata_sambutan" name="kata_sambutan"
                                    cols="30" rows="3" placeholder="Masukan kata sambutan kepala sekolah" required>{{ old('kata_sambutan', $setting['kata_sambutan']->value ?? '') }}</textarea>
                                @error('kata_sambutan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tahun Ajaran & Kalender Akademik</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.tahun_ajaran') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="tahun_ajaran">Tahun Ajaran Aktif</label>
                                <input type="text"
                                    class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                    id="tahun_ajaran" name="tahun_ajaran"
                                    value="{{ old('tahun_ajaran', $setting['tahun_ajaran']->value ?? '') }}"
                                    placeholder="Masukan Tahun Ajaran" required>
                                @error('tahun_ajaran')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="semester">Semester Berjalan</label>
                                <select class="form-control @error('semester') is-invalid @enderror" id="semester"
                                    name="semester" required>
                                    <option value="1"
                                        {{ old('semester', $setting['semester']->value ?? '') == '1' ? 'selected' : '' }}>
                                        Ganjil
                                    </option>
                                    <option value="2"
                                        {{ old('semester', $setting['semester']->value ?? '') == '2' ? 'selected' : '' }}>
                                        Genap
                                    </option>
                                </select>
                                @error('semester')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kalender_akademik">Kalender Akademik</label>
                                <input type="file"
                                    class="form-control @error('kalender_akademik') is-invalid @enderror"
                                    id="kalender_akademik" name="kalender_akademik">
                                @error('kalender_akademik')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Logo & Branding</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="logo_sekolah">Logo Sekolah</label>
                                <input type="file"
                                    class="form-control @error('logo_sekolah') is-invalid @enderror"
                                    id="logo_sekolah" name="logo_sekolah" required>
                                @if (isset($identitas['logo_sekolah']->value))
                                    <img src="{{ asset('storage/image/logo' . $identitas['logo_sekolah']->value) }}"
                                        alt="Logo Sekolah" width="100">
                                @endif
                                @error('logo_sekolah')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="background_image">Background</label>
                                <input type="file"
                                    class="form-control @error('background_image') is-invalid @enderror"
                                    id="background_image" name="background_image" required>
                                @if (isset($identitas['background_image']->value))
                                    <img src="{{ asset('storage/image/logo' . $identitas['background_image']->value) }}"
                                        alt="Background Login" width="100">
                                @endif
                                @error('background_image')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
