<x-app-layout :title="$title">
    <div class="container">
        <div class="card">
            <div class="card-header">Import Kehadiran Siswa</div>
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
                <form action="{{ route('kehadiran.importProcess') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
                <a href="{{ asset('file/absen.xlsx') }}" class="">Download Template</a>
            </div>
        </div>
    </div>
</x-app-layout>
