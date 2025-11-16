<div>
    <x-slot name="title">Data Sosial Media</x-slot>

    <x-slot name="pageTitle">Data Sosial Media</x-slot>

    <x-slot name="pagePretitle">Kelola Data Sosial Media</x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row">
        <div class="col-12 col-lg-4 mb-md-0 mb-5">
            <form wire:submit="saveCategoryProduct" class="card">
                <div class="card-header">Form Sosial Media</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-form.input wire:model="namaSosialMedia" name="namaSosialMedia" label="Nama Sosial Media"
                                placeholder="Masukkan komentar" type="text" />

                            <x-form.toggle wire:model="isActive" name="isActive" label="Status Aktif" />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <button type="reset" class="btn">Reset</button>

                        <x-datatable.button.save target="saveCategoryProduct"
                            name="{{ $this->socialMediaId ? 'Sunting' : 'Tambah' }}" />
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 col-lg-8">
            <div class="row mb-3 align-items-center justify-content-between">
                <div class="col-12 col-lg-7 d-flex">
                    <div>
                        <x-datatable.search placeholder="Cari komentar..." />
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

                    <button wire:click="muatUlang" class="btn py-1 ms-2"><span
                            class="las la-redo-alt fs-1"></span></button>
                </div>
            </div>

            <div class="card" wire:loading.class.delay="card-loading" wire:offline.class="card-loading">
                <div class="table-responsive mb-0">
                    <table class="table card-table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="w-1">
                                    <x-datatable.bulk.check wire:model.lazy="selectPage" />
                                </th>

                                <th>
                                    <x-datatable.column-sort name="Nama Sosial Media" wire:click="sortBy('name_232187')"
                                        :direction="$sorts['name_232187'] ?? null" />
                                </th>

                                <th>
                                    <x-datatable.column-sort name="Status Aktif" wire:click="sortBy('is_active_232187')"
                                        :direction="$sorts['is_active_232187'] ?? null" />
                                </th>

                                <th style="width: 10px"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($selectPage)
                                <tr>
                                    <td colspan="10" class="bg-blue-lt rounded-0">
                                        @if (!$selectAll)
                                            <div class="text-blue">
                                                <span>Anda telah memilih <strong>{{ $this->rows->total() }}</strong>
                                                    sosial media,
                                                    apakah
                                                    Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                                    sosial media?</span>

                                                <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                                    Pilih Semua Data sosial media
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-pink">Anda sekarang memilih semua
                                                <strong>{{ count($this->selected) }}</strong> sosial media.
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @forelse ($this->rows as $row)
                                <tr wire:key="row-{{ $row->id_232187 }}"
                                    class="{{ $row->id_232187 == $this->socialMediaId ? 'bg-orange-lt rounded-0' : '' }}">
                                    <td class="rounded-0">
                                        <x-datatable.bulk.check wire:model.lazy="selected"
                                            value="{{ $row->id_232187 }}" />
                                    </td>

                                    <td class="rounded-0">{{ $row->name_232187 ?? '-' }}</td>

                                    <td>
                                        <button wire:click="changeStatus({{ $row->id_232187 }})"
                                            class="btn btn-{{ $row->is_active_232187 ? 'green' : 'dark' }}" type="button">
                                            {{ $row->is_active_232187 ? 'Sync' : 'Async' }} <i
                                                class="las la-redo-alt ms-1 fw-bold fs-2"></i>
                                        </button>
                                    </td>

                                    <td class="rounded-0">
                                        @if ($this->socialMediaId == $row->id_232187)
                                            <button wire:click="closeModal" class="btn btn-danger" type="button">Batal
                                                <span class="las la-times fs-2 ms-1"></span></button>
                                        @else
                                            <button wire:click="openModal({{ $row->id_232187 }})" class="btn btn-dark"
                                                type="button">Edit <span class="las la-edit fs-2 ms-1"></span></button>
                                        @endif
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
    </div>
