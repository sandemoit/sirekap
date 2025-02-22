<x-guest-layout>
    <section id="hero" class="hero section dark-background">

        <img src="{{ asset('storage/' . configWeb('background_image')->value) }}" alt="" data-aos="fade-in">

        <div class="container">
            <p data-aos="fade-up" data-aos-delay="200">Welcome to {{ configWeb('nama_sekolah')->value }}</p>
            <h2 data-aos="fade-up" data-aos-delay="100">Portal Informasi,<br>Sekolah Digital</h2>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="courses.html" class="btn-get-started">Get Started</a>
            </div>
        </div>

    </section>

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                    <p class="fst-italic">Sambutan dari</p>
                    <h3>Kepala Sekolah {{ configWeb('nama_sekolah')->value }}</h3>
                    <p>{{ configWeb('kata_sambutan')->value }}</p>
                    <a href="javascript:;" class="read-more"><span><i class="bi bi-person-up"></i>
                            {{ configWeb('nama_kepsek')->value }}</span></a>
                </div>
                <div class="col-lg-6 order-1 order-lg-2" style="text-align: center" data-aos="fade-up"
                    data-aos-delay="100">
                    <img src="{{ asset('storage/' . configWeb('foto_kepsek')->value) }}" class="img-fluid"
                        alt="Kepala Sekolah {{ configWeb('nama_sekolah')->value }}">
                </div>
            </div>
        </div>
    </section>
    <!-- /About Section -->

    <section id="gallery" class="events section">
        <div class="justify-content-center text-center mb-5" data-aos-delay="200" data-aos="fade-down">
            <h3>Kejuaraan yang Sekolah Kami Raih</h3>
        </div>
        <div class="container" data-aos="fade-up">

            <div class="row">
                @foreach ($competition as $key)
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card">
                            <div class="card-img">
                                <img src="{{ asset('storage/' . $key->image) }}" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="javascript:void(0);">{{ $key->competition_name }}</a>
                                </h5>
                                <p class="fst-italic text-center">{{ tanggal($key->date) }}</p>
                                <p class="card-text">{{ $key->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    </section>
</x-guest-layout>
