<div>
    <x-slot name="title">Pengguna Aplikasi</x-slot>

    <x-slot name="pageTitle">Pengguna Aplikasi</x-slot>

    <x-slot name="pagePretitle">Kelola Data Pengguna Aplikasi</x-slot>

    <x-slot name="button">
        <x-datatable.button.add name="Tambah Pengguna" :route="route('user.create')" />
    </x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row mb-3 align-items-center justify-content-between">
        <div class="col-12 col-lg-8 d-flex align-self-center">
            <div>
                <x-datatable.search placeholder="Cari nama pengguna..." />
            </div>
        </div>
        <div class="col-auto ms-auto d-flex mt-lg-0 mt-3">
            <x-datatable.items-per-page />

            <x-datatable.bulk.dropdown>
                <div class="dropdown-menu dropdown-menu-end datatable-dropdown">
                    <button data-bs-toggle="modal" data-bs-target="#delete-confirmation" class="dropdown-item"
                        type="button">
                        <i class="las la-trash me-3"></i>

                        <span>Hapus</span>
                    </button>
                </div>
            </x-datatable.bulk.dropdown>

            <button wire:click="muatUlang" class="btn py-1 ms-2"><span class="las la-redo-alt fs-1"></span></button>
        </div>
    </div>

    <div wire:poll.30000ms class="card" wire:loading.class.delay="card-loading" wire:offline.class="card-loading">
        <div class="table-responsive mb-0">
            <table class="table card-table table-bordered datatable">
                <thead>
                    <tr>
                        <th class="w-1">
                            <x-datatable.bulk.check wire:model.lazy="selectPage" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Nama Pengguna" wire:click="sortBy('username')"
                                :direction="$sorts['username'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Level" wire:click="sortBy('role')" :direction="$sorts['role'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Email" wire:click="sortBy('email')" :direction="$sorts['email'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Status" wire:click="sortBy('email_verified_at')"
                                :direction="$sorts['email_verified_at'] ?? null" />
                        </th>

                        <th style="width: 10px"></th>
                    </tr>
                </thead>

                <tbody>
                    @if ($selectPage)
                        <tr>
                            <td colspan="10" class="bg-orange-lt rounded-0">
                                @if (!$selectAll)
                                    <div class="text-orange">
                                        <span>Anda telah memilih <strong>{{ $this->rows->total() }}</strong> pengguna,
                                            apakah
                                            Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                            pengguna?</span>

                                        <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                            Pilih Semua Data Pengguna
                                        </button>
                                    </div>
                                @else
                                    <span class="text-pink">Anda sekarang memilih semua
                                        <strong>{{ count($this->selected) }}</strong> pengguna.
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @forelse ($this->rows as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td>
                                <x-datatable.bulk.check wire:model.lazy="selected" value="{{ $row->id }}" />
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm px-3 me-3"
                                        style="background-image: url({{ $row->avatarUrl() }})"></span>

                                    @if (is_online($row->id))
                                        <span class="badge bg-success me-1"></span>
                                    @else
                                        <span class="badge bg-secondary me-1" title="{{ $row->last_seen_time }}"></span>
                                    @endif

                                    <span>{{ $row->username }}</span>
                                </div>
                            </td>

                            <td>
                                <span @class([
                                    'badge',
                                    'bg-orange' => $row->role == 'user',
                                    'bg-lime' => $row->role == 'admin',
                                    'bg-green' => $row->role == 'superadmin',
                                    'bg-blue' => $row->role == 'developer',
                                ])>{{ $row->role }}</span>
                            </td>

                            <td>{{ $row->email ?? '-' }}</td>

                            <td style="width: 90px" class="px-4">
                                @if (auth()->user()->role == 'developer')
                                    <button wire:click="changeStatus({{ $row->id }})"
                                        class="btn btn-{{ $row->email_verified_at ? 'green' : 'dark' }}"
                                        type="button">
                                        {{ $row->email_verified_at ? 'Aktif' : 'Nonaktif' }} <i
                                            class="las la-redo-alt ms-1 fw-bold fs-2"></i>
                                    </button>
                                @else
                                    <span class="badge bg-{{ $row->email_verified_at ? 'lime' : 'red' }}">
                                        {{ $row->email_verified_at ? 'aktif' : 'nonaktif' }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <a class="btn btn-sm" href="{{ route('user.edit', $row->id) }}">
                                            Sunting
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-datatable.empty colspan="10" />
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $this->rows->links() }}
    </div>
</div>
