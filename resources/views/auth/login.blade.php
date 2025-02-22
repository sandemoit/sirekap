<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section id="contact" class="contact section">
        <div class="container">

            <div class="row justify-content-center py-5">
                <div class="col-lg-6 col-sm-12 gy-4">
                    <div class="card">
                        <div class="card-body">
                            <form class="php-email-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" id="password" placeholder="Email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" id="password" placeholder="Password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('ortu.login') }}" class="btn btn-primary mt-3">Masuk Sebagai Orang
                        tua</a>
                </div>

            </div>

        </div>

    </section>
</x-guest-layout>
