<div>
    <x-slot name="title">Data Komentar</x-slot>

    <x-slot name="pageTitle">Data Komentar</x-slot>

    <x-slot name="pagePretitle">Kelola Data Komentar</x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row">
        <div class="col-12 col-lg-4 mb-md-0 mb-5">
            <form wire:submit="saveCategoryProduct" class="card">
                <div class="card-header">Form Komentar</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-form.input wire:model="komentarSentiment" name="komentarSentiment" label="Nama Komentar"
                                placeholder="Masukkan komentar" type="text" />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <button type="reset" class="btn">Reset</button>

                        <x-datatable.button.save target="saveCategoryProduct"
                            name="{{ $this->commentId ? 'Sunting' : 'Tambah' }}" />
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 col-lg-8">
            <div class="row mb-3 align-items-center justify-content-between">
                <div class="col-12 col-lg-7 d-flex">
                    <div class="w-full">
                        <x-datatable.search placeholder="Cari komentar..." />
                    </div>
                    <div class="w-33 ms-2">
                        <x-form.select wire:model.live="filters.status" name="filters.status" form-group-class>
                            <option value="">- SEMUA STATUS -</option>
                            @foreach (config('const.sentiment_status') as $status)
                                <option value="{{ $status }}">{{ strtoupper($status) }}</option>
                            @endforeach
                        </x-form.select>
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
                                    <x-datatable.column-sort name="Komentar" wire:click="sortBy('comment')"
                                        :direction="$sorts['comment'] ?? null" />
                                </th>

                                <th>
                                    <x-datatable.column-sort name="Status" wire:click="sortBy('status')"
                                        :direction="$sorts['status'] ?? null" />
                                </th>

                                <th>
                                    <x-datatable.column-sort name="Tanggal" wire:click="sortBy('created_at')"
                                        :direction="$sorts['created_at'] ?? null" />
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
                                                    komentar,
                                                    apakah
                                                    Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                                    komentar?</span>

                                                <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                                    Pilih Semua Data komentar
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-pink">Anda sekarang memilih semua
                                                <strong>{{ count($this->selected) }}</strong> komentar.
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @forelse ($this->rows as $row)
                                <tr wire:key="row-{{ $row->id }}"
                                    class="{{ $row->id == $this->commentId ? 'bg-green-lt' : '' }}">
                                    <td>
                                        <x-datatable.bulk.check wire:model.lazy="selected"
                                            value="{{ $row->id }}" />
                                    </td>

                                    <td>{{ $row->comment ?? '-' }}</td>

                                    <td>
                                        <span @class([
                                            'badge',
                                            'bg-red' => $row->status == 'negatif',
                                            'bg-primary' => $row->status == 'netral',
                                            'bg-green' => $row->status == 'positif',
                                        ])>{{ $row->status }}</span>
                                    </td>

                                    <td>{{ $row->created_at ?? '-' }}</td>

                                    <td>
                                        @if ($this->commentId == $row->id)
                                            <button wire:click="closeModal" class="btn btn-danger" type="button">Batal
                                                <span class="las la-times fs-2 ms-1"></span></button>
                                        @else
                                            <button wire:click="openModal({{ $row->id }})" class="btn btn-dark"
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
