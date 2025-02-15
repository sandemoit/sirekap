<x-app-layout :title="$title">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <a href="{{ route('competition.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        </div>

        <div class="row">
            @foreach ($competitions as $key)
                <div class="col-3">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('storage/' . $key->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $key->competition_name }}</h5>
                            <p class="card-text">{{ $key->description }}</p>
                            <button type="button" class="btn btn-primary"><i class="fas fa-calendar-week"></i>
                                {{ tanggal($key->date) }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
