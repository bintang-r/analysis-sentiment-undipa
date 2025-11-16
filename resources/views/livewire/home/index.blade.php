<div>
    <x-slot name="title">Beranda</x-slot>

    <x-slot name="pagePretitle">Ringkasan aplikasi anda berada disini.</x-slot>

    <x-slot name="pageTitle">Beranda</x-slot>

    <div class="card mt-4" wire:poll.30000ms>
        <h4 class="card-header">Riwayat Login Pengguna</h4>
        <div class="card-body">
            <div class="row">
                @forelse ($login_history as $login)
                    <div class="col col-md-4 col-xl-3 mb-2">
                        <div>
                            <div class="d-flex">
                                <div class="mt-1 ms-1">
                                    <img style="width: 53px; height: 53px; object-fit:cover; border-radius: 10px"
                                        src="{{ $login->avatarUrl() }}" alt="avatar">
                                </div>

                                <div class="ms-2">
                                    <div class="header font-weight-bold">
                                        <small><b>{{ $login->username_232187 ?? '-' }}</b></small>

                                        @if (is_online($login->id_232187))
                                            <span class="badge bg-success ms-1"></span>
                                        @else
                                            <small class="badge bg-secondary ms-1"
                                                title="{{ $login->last_seen_time_232187 }}"></small>
                                        @endif
                                    </div>

                                    <div class="subheader mb-1">
                                        {{ \Carbon\Carbon::parse($login->last_login_time_232187)->diffForHumans() ?? '-' }}
                                    </div>

                                    <div class="subheader mb-1">
                                        <span @class([
                                            'badge',
                                            'bg-green-lt' => $login->role_232187 == 'admin',
                                            'bg-blue-lt' => $login->role_232187 == 'user',
                                        ])>{{ $login->role_232187 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="las la-clock" style="font-size:50px"></i>
                        </div>

                        <p class="empty-title">Data Riwayat Login Belum Ada.</p>

                        <p class="empty-subtitle text-muted">
                            Data riwayat login akan muncul dengan sendirinya, ketika akun pengguna sedang login.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
