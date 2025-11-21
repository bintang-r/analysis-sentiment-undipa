<x-layouts.auth title="Register">
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Registrasi Akun</h2>

            <form action="{{ route('register.process') }}" method="POST" autocomplete="off">
                @csrf

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input class="form-control" 
                           type="text" 
                           name="nama" 
                           value="{{ old('nama') }}" 
                           required 
                           autofocus
                           placeholder="Masukkan nama lengkap">
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="contoh@gmail.com">
                </div>

                {{-- PASSWORD --}}
                <div class="mb-2">
                    <label class="form-label">
                        <span>Kata Sandi</span>
                    </label>

                    <div class="input-group input-group-flat">
                        <input class="form-control"
                               name="password"
                               type="password"
                               placeholder="******"
                               autocomplete="new-password"
                               required>

                        <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                @include('partials.svg.eye')
                            </a>
                        </span>
                    </div>
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="mb-2">
                    <label class="form-label">
                        <span>Konfirmasi Sandi</span>
                    </label>

                    <div class="input-group input-group-flat">
                        <input class="form-control"
                               name="password_confirmation"
                               type="password"
                               placeholder="******"
                               autocomplete="new-password"
                               required>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </div>

            </form>
        </div>
    </div>
</x-layouts.auth>
