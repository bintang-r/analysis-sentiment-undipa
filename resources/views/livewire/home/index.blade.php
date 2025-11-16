<div>
    {{-- Page Slots --}}
    <x-slot name="title">Beranda</x-slot>
    <x-slot name="pagePretitle">Ringkasan aplikasi anda berada disini.</x-slot>
    <x-slot name="pageTitle">Beranda</x-slot>

    <div class="row">

        {{-- =========================== --}}
        {{-- KOL 1 — KARTU + LOGIN LOG   --}}
        {{-- =========================== --}}
        <div class="col-12 col-md-4 col-lg-3">

            {{-- Count Cards --}}
            <x-card.count-data title="Pengguna" :total="$this->totalUser" icon="user" color="blue" />
            <x-card.count-data title="Komentar" :total="$this->totalComment" icon="comment" color="red" />
            <x-card.count-data title="Sosial Media" :total="$this->totalSocialMedia" icon="globe" color="green" />

            {{-- Login History --}}
            <div class="mt-5">
                <div class="card mt-4" wire:poll.30000ms>
                    <h4 class="card-header">Riwayat Login Pengguna</h4>

                    <div class="card-body d-flex">
                        <div class="row">

                            @forelse ($login_history as $login)
                                <div class="col-12 mb-2">
                                    <div class="d-flex">

                                        {{-- Avatar --}}
                                        <div class="mt-1 ms-1">
                                            <img src="{{ $login->avatarUrl() }}" alt="avatar"
                                                style="width:53px; height:53px; object-fit:cover; border-radius:10px;">
                                        </div>

                                        {{-- User Info --}}
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
                                        <i class="las la-clock" style="font-size:50px;"></i>
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

        </div>



        {{-- =========================== --}}
        {{-- KOL 2 — BAR CHART + PIE     --}}
        {{-- =========================== --}}
        <div class="col-12 col-md-8 col-lg-9">

            {{-- BAR CHART CARD --}}
            <div class="card h-100 mb-3 w-100 d-flex">

                <div class="card-header text-center d-flex justify-content-between">
                    <h4 class="mb-0 pb-0 align-self-center">
                        Total Hasil Analisis
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
                                } }}
                            </option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="card-body py-2 mb-5">
                    <div wire:ignore>
                        <div id="chart-mentions" class="chart-lg"
                            total_positif="{{ json_encode($this->totalPositifChart['data']) }}"
                            total_negatif="{{ json_encode($this->totalNegatifChart['data']) }}"
                            total_netral="{{ json_encode($this->totalNetralChart['data']) }}"
                            date="{{ json_encode($this->totalPositifChart['date']) }}">
                        </div>
                    </div>
                </div>



                {{-- PIE CHART CARD --}}
                <div class="card h-100 w-100 mt-5">

                    <div class="card-header text-center">
                        <h4 class="mb-0 pb-0">Persentase Sentimen</h4>
                    </div>

                    <div class="card-body">
                        <div wire:ignore>

                            <div id="chart-percent" positif="{{ $positifPercent }}" negatif="{{ $negatifPercent }}"
                                netral="{{ $netralPercent }}">
                            </div>

                            <div class="text-center mt-3">
                                <span class="badge bg-success p-2">Positif: {{ $positifPercent }}%</span>
                                <span class="badge bg-danger p-2">Negatif: {{ $negatifPercent }}%</span>
                                <span class="badge bg-primary p-2">Netral: {{ $netralPercent }}%</span>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>



{{-- =============================== --}}
{{-- SCRIPT : BAR + PIE CHART        --}}
{{-- =============================== --}}
@push('scripts')
    {{-- BAR CHART --}}
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
                            borderRadiusApplication: "end",
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

                    colors: ["#34d399", "#fb7185", "#60a5fa"],

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
                    }
                });

                chart.render();
            }

            // Update via Livewire
            Livewire.on("updateChart", (data) => {
                const d = data[0];
                renderChart(d.total_positif, d.total_negatif, d.total_netral, d.date);
            });

            // First Render
            renderChart(
                JSON.parse(item.getAttribute("total_positif")),
                JSON.parse(item.getAttribute("total_negatif")),
                JSON.parse(item.getAttribute("total_netral")),
                JSON.parse(item.getAttribute("date"))
            );
        });
    </script>



    {{-- PIE CHART --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let pieChart;
            const pieItem = document.getElementById('chart-percent');

            function renderPieChart(positif, negatif, netral) {

                if (!pieItem) return;
                if (pieChart) pieChart.destroy();

                pieChart = new ApexCharts(pieItem, {
                    chart: {
                        type: "pie",
                        height: 340,
                        toolbar: {
                            show: false
                        }
                    },
                    labels: ["Positif", "Negatif", "Netral"],
                    series: [positif, negatif, netral],
                    colors: ["#34d399", "#fb7185", "#60a5fa"],
                    legend: {
                        position: "bottom",
                        fontSize: "14px"
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val.toFixed(1) + "%"
                    }
                });

                pieChart.render();
            }

            // First Render
            renderPieChart(
                parseFloat(pieItem.getAttribute("positif")),
                parseFloat(pieItem.getAttribute("negatif")),
                parseFloat(pieItem.getAttribute("netral"))
            );

            // Update via Livewire
            Livewire.on("updateChart", (data) => {
                const p = data[0].percent;
                renderPieChart(p.positif, p.negatif, p.netral);
            });

        });
    </script>
@endpush
