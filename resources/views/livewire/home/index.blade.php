<div>
    <x-slot name="title">Beranda</x-slot>
    <x-slot name="pagePretitle">Ringkasan aplikasi anda berada disini.</x-slot>
    <x-slot name="pageTitle">Beranda</x-slot>

    <div class="row">
        {{-- Kartu Data --}}
        <div class="col-12 col-md-4 col-lg-3">
            <x-card.count-data title="Pengguna" :total="$this->totalUser" icon="user" color="blue" />

            <x-card.count-data title="Komentar" :total="$this->totalComment" icon="comment" color="red" />

            <x-card.count-data title="Sosial Media" :total="$this->totalSocialMedia" icon="globe" color="green" />
        </div>

        {{-- Chart Presensi --}}
        <div class="col-12 col-md-8 col-lg-9">
            <div class="card h-100 mb-3 w-100 d-flex">
                <div class="card-header text-center d-flex justify-content-between">
                    <h4 class="mb-0 pb-0 align-self-center">
                        Data Presensi
                        @switch($this->period)
                            @case('daily')
                                10 Hari Terakhir
                            @break

                            @case('weekly')
                                10 Minggu Terakhir
                            @break

                            @case('monthly')
                                10 Bulan Terakhir
                            @break

                            @case('yearly')
                                10 Tahun Terakhir
                            @break
                        @endswitch
                    </h4>

                    <x-form.select wire:model.live="period" name="period">
                        <option value=""></option>
                        @foreach (config('const.periods') as $period)
                            <option wire:key="{{ $period }}" value="{{ $period }}">
                                {{ match ($period) {
                                    'daily' => '10 HARI TERAKHIR',
                                    'weekly' => '10 MINGGU TERAKHIR',
                                    'monthly' => '10 BULAN TERAKHIR',
                                    'yearly' => '10 TAHUN TERAKHIR',
                                    default => '',
                                } }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="card-body py-2">
                    <div wire:ignore>
                        <div id="chart-mentions" class="chart-lg"
                            total_negatif="{{ json_encode($this->totalNegatifChart['data']) }}"
                            total_positif="{{ json_encode($this->totalPositifChart['data']) }}"
                            total_netral="{{ json_encode($this->totalNetralChart['data']) }}"
                            date="{{ json_encode($this->totalPositifChart['date']) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Login --}}
    <div class="card mt-4" wire:poll.30000ms>
        <h4 class="card-header">Riwayat Login Pengguna</h4>

        <div class="card-body">
            <div class="row">
                @forelse ($login_history as $login)
                    <div class="col col-md-4 col-xl-3 mb-2">
                        <div class="d-flex">
                            <div class="mt-1 ms-1">
                                <img src="{{ $login->avatarUrl() }}" alt="avatar"
                                    style="width: 53px; height: 53px; object-fit:cover; border-radius: 10px">
                            </div>

                            <div class="ms-2">
                                <div class="header font-weight-bold">
                                    <small><b>{{ $login->username_232187 ?? '-' }}</b></small>

                                    @if (is_online($login->id_232187))
                                        <span class="badge bg-success ms-1"></span>
                                    @else
                                        <small class="badge bg-secondary ms-1"
                                            title="{{ $login->last_seen_time_232187 }}">
                                        </small>
                                    @endif
                                </div>

                                <div class="subheader mb-1">
                                    {{ \Carbon\Carbon::parse($login->last_login_time_232187)->diffForHumans() ?? '-' }}
                                </div>

                                <div class="subheader mb-1">
                                    <span @class([
                                        'badge',
                                        'bg-green-lt' => $login->role_232187 === 'admin',
                                        'bg-blue-lt' => $login->role_232187 === 'user',
                                    ])>
                                        {{ $login->role_232187 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty text-center">
                        <div class="empty-icon">
                            <i class="las la-clock" style="font-size:50px"></i>
                        </div>

                        <p class="empty-title">Data Riwayat Login Belum Ada.</p>
                        <p class="empty-subtitle text-muted">
                            Data riwayat login akan muncul ketika akun pengguna sedang login.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let chart;
            const item = document.getElementById('chart-mentions');

            function renderChart(total_positif, total_negatif, total_netral, date) {
                if (!item) return console.error("#chart-mentions tidak ditemukan!");

                if (chart) chart.destroy();

                chart = new ApexCharts(item, {
                    chart: {
                        type: "bar",
                        stacked: true,
                        height: 360,
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: "easeout",
                            speed: 800
                        },
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            blur: 4,
                            opacity: 0.15
                        }
                    },

                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 8,
                            columnWidth: "45%",
                            borderRadiusApplication: "end", // ujung atas rounded
                        }
                    },

                    tooltip: {
                        theme: "dark",
                        shared: true,
                        intersect: false,
                        style: {
                            fontSize: "13px"
                        }
                    },

                    dataLabels: {
                        enabled: false
                    },

                    series: [{
                            name: "Total Positif",
                            data: total_positif
                        },
                        {
                            name: "Total Negatif",
                            data: total_negatif
                        },
                        {
                            name: "Total Netral",
                            data: total_netral
                        }
                    ],

                    xaxis: {
                        categories: date,
                        labels: {
                            style: {
                                fontSize: "12px",
                                fontWeight: 500
                            }
                        }
                    },

                    yaxis: {
                        labels: {
                            style: {
                                fontSize: "12px",
                                fontWeight: 500
                            }
                        }
                    },

                    grid: {
                        borderColor: "#e2e8f0",
                        strokeDashArray: 4,
                    },

                    colors: [
                        "#34d399", // hijau pastel
                        "#fb7185", // merah soft
                        "#60a5fa" // biru soft
                    ],

                    legend: {
                        position: "top",
                        horizontalAlign: "center",
                        fontSize: "14px",
                        itemMargin: {
                            horizontal: 10
                        },
                        markers: {
                            radius: 12
                        }
                    },

                    fill: {
                        type: "gradient",
                        // gradient: {
                        //     shade: "light",
                        //     type: "vertical",
                        //     shadeIntensity: 0.3,
                        //     opacityFrom: 0.9,
                        //     opacityTo: 0.6,
                        // }
                    }
                });

                chart.render();
            }

            // Event dari Livewire
            Livewire.on('updateChart', (data) => {
                const d = data[0];
                renderChart(d.total_positif, d.total_negatif, d.total_netral, d.date);
            });

            // Render pertama (initial load)
            renderChart(
                JSON.parse(item.getAttribute('total_positif')),
                JSON.parse(item.getAttribute('total_negatif')),
                JSON.parse(item.getAttribute('total_netral')),
                JSON.parse(item.getAttribute('date'))
            );
        });
    </script>
@endpush
