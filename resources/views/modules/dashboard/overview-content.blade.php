@php
    $chartMaximum = (int) $productionTrend->max('total');
    $chartScale = max(1, $chartMaximum);
    $chartPoints = [];

    foreach ($productionTrend->values() as $index => $day) {
        $chartPoints[] = [
            'x' => 52 + ($index * 74),
            'y' => 198 - (($day['total'] / $chartScale) * 144),
            'day' => $day,
        ];
    }

    $linePath = collect($chartPoints)
        ->map(fn (array $point): string => $point['x'].','.$point['y'])
        ->implode(' ');
    $firstPoint = $chartPoints[0];
    $lastPoint = $chartPoints[array_key_last($chartPoints)];
    $areaPath = 'M '.$firstPoint['x'].' 198 L '.str_replace(' ', ' L ', $linePath).' L '.$lastPoint['x'].' 198 Z';
    $speciesColors = ['#96ca50', '#3d4658', '#f59e0b', '#3b82f6', '#ef4444'];
    $speciesTotal = (int) $speciesComposition->sum('total');
    $speciesGradientSegments = [];
    $speciesCumulativeTotal = 0;

    foreach ($speciesComposition->values() as $index => $species) {
        $speciesCumulativeTotal += (int) $species->total;
        $segmentEnd = $speciesTotal > 0 ? round($speciesCumulativeTotal / $speciesTotal * 100, 2) : 0;
        $segmentStart = $index === 0
            ? 0
            : round(($speciesCumulativeTotal - (int) $species->total) / $speciesTotal * 100, 2);
        $speciesGradientSegments[] = $speciesColors[$index % count($speciesColors)]." {$segmentStart}% {$segmentEnd}%";
    }

    $speciesGradient = implode(', ', $speciesGradientSegments);
@endphp

<section class="dashboard-welcome">
    <div>
        <p class="dashboard-eyebrow">Ringkasan peternakan</p>
        <h1>@yield('heading')</h1>
        <p class="dashboard-muted">@yield('description')</p>
    </div>
    <span class="dashboard-welcome-mark" aria-hidden="true"><i class="bi bi-sun"></i></span>
</section>

<section class="dashboard-stat-grid" aria-label="Ringkasan statistik peternakan">
    @include('modules.dashboard.components.stat-card', [
        'icon' => 'bi-box-seam',
        'label' => 'Ternak Aktif',
        'value' => number_format($activeAnimals, 0, ',', '.'),
        'description' => 'Jumlah ternak terdaftar',
    ])
    @include('modules.dashboard.components.stat-card', [
        'icon' => 'bi-house-door',
        'color' => 'blue',
        'label' => 'Kapasitas Kandang',
        'value' => $capacityPercentage.'%',
        'description' => number_format($activeAnimals, 0, ',', '.').' / '.number_format($activeBarnCapacity, 0, ',', '.').' slot',
    ])
    @include('modules.dashboard.components.stat-card', [
        'icon' => 'bi-droplet-half',
        'color' => 'orange',
        'label' => 'Produksi Hari Ini',
        'value' => $productionValue,
        'description' => $productionDescription,
    ])
    @include('modules.dashboard.components.stat-card', [
        'icon' => 'bi-heart-pulse',
        'color' => 'red',
        'label' => 'Pemeriksaan Hari Ini',
        'value' => number_format($todayHealthRecords, 0, ',', '.'),
        'description' => 'Rekam kesehatan tercatat',
    ])
</section>

<section class="dashboard-analytics-grid" aria-label="Grafik peternakan">
    <article class="dashboard-panel dashboard-trend-panel">
        <div class="dashboard-panel-heading">
            <div>
                <h2>Tren Produksi</h2>
                <p>Jumlah pencatatan produksi selama 7 hari terakhir</p>
            </div>
            <span class="dashboard-period-badge">7 Hari</span>
        </div>

        <div class="dashboard-chart">
            <div class="dashboard-chart-axis" aria-hidden="true">
                <span>{{ $chartMaximum }}</span>
                <span>{{ (int) round($chartMaximum / 2) }}</span>
                <span>0</span>
            </div>
            <svg viewBox="0 0 530 245" role="img" aria-label="Grafik jumlah pencatatan produksi tujuh hari terakhir">
                <defs>
                    <linearGradient id="production-area" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#96ca50" stop-opacity=".24" />
                        <stop offset="100%" stop-color="#96ca50" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <line class="dashboard-chart-gridline" x1="38" y1="54" x2="520" y2="54" />
                <line class="dashboard-chart-gridline" x1="38" y1="126" x2="520" y2="126" />
                <line class="dashboard-chart-gridline" x1="38" y1="198" x2="520" y2="198" />
                <path class="dashboard-chart-area" d="{{ $areaPath }}" />
                <polyline class="dashboard-chart-line" points="{{ $linePath }}" />
                @foreach ($chartPoints as $point)
                    <circle class="dashboard-chart-point" cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4">
                        <title>{{ $point['day']['date'] }}: {{ $point['day']['total'] }} catatan</title>
                    </circle>
                    <text class="dashboard-chart-label" x="{{ $point['x'] }}" y="226" text-anchor="middle">
                        {{ $point['day']['date'] }}
                    </text>
                @endforeach
            </svg>
        </div>
    </article>

    <article class="dashboard-panel dashboard-species-panel">
        <div class="dashboard-panel-heading">
            <div>
                <h2>Komposisi Ternak</h2>
                <p>Populasi berdasarkan jenis ternak</p>
            </div>
        </div>

        @if ($speciesComposition->isNotEmpty())
            <div class="dashboard-donut-wrap">
                <div
                    class="dashboard-donut"
                    @style(['background: conic-gradient('.$speciesGradient.')'])
                    role="img"
                    aria-label="Komposisi {{ $speciesTotal }} ternak berdasarkan jenis"
                >
                    <span>{{ number_format($speciesTotal, 0, ',', '.') }}<small>Ternak</small></span>
                </div>
            </div>
            <ul class="dashboard-species-legend">
                @foreach ($speciesComposition->values() as $index => $species)
                    <li>
                        <span class="dashboard-legend-name">
                            <span class="dashboard-legend-dot" style="--legend-color: {{ $speciesColors[$index % count($speciesColors)] }}"></span>
                            {{ $species->jenisTernak->nama }}
                        </span>
                        <span class="dashboard-legend-total">
                            {{ number_format($species->total, 0, ',', '.') }}
                            <small>{{ number_format($species->total / $speciesTotal * 100, 0) }}%</small>
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="dashboard-chart-empty">
                <span class="dashboard-empty-icon"><i class="bi bi-pie-chart"></i></span>
                <p>Belum ada data ternak untuk ditampilkan.</p>
            </div>
        @endif
    </article>
</section>

<section class="dashboard-details-grid">
    <article class="dashboard-panel dashboard-health-panel">
        <div class="dashboard-panel-heading">
            <div>
                <h2>Laporan Kesehatan Terbaru</h2>
                <p>{{ $healthRecords->count() }} pemeriksaan terakhir</p>
            </div>
            <a href="{{ route($healthRecordsRoute) }}" class="dashboard-view-all">
                <i class="bi bi-arrow-right" aria-hidden="true"></i> Lihat Semua
            </a>
        </div>

        <div class="dashboard-table-wrap">
            <table class="dashboard-health-table">
                <thead>
                    <tr>
                        <th scope="col">ID TERNAK</th>
                        <th scope="col">JENIS</th>
                        <th scope="col">DIAGNOSA</th>
                        <th scope="col">PETUGAS</th>
                        <th scope="col">TANGGAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($healthRecords as $record)
                        <tr>
                            <td><strong>#{{ $record->ternak->kode }}</strong></td>
                            <td>{{ $record->ternak->jenisTernak->nama }}</td>
                            <td><span class="dashboard-diagnosis">{{ $record->diagnosa }}</span></td>
                            <td>{{ $record->petugas->user->nama }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($record->tgl_pemeriksaan)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="dashboard-table-empty">Belum ada rekam kesehatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <article class="dashboard-panel dashboard-staff-panel">
        <div class="dashboard-panel-heading">
            <div>
                <h2>Petugas Aktif</h2>
                <p>Petugas dengan status akun aktif</p>
            </div>
        </div>

        @if ($activeStaff->isNotEmpty())
            <ul class="dashboard-staff-list">
                @foreach ($activeStaff as $staff)
                    <li>
                        <span class="dashboard-staff-avatar" aria-hidden="true">
                            {{ mb_strtoupper(mb_substr($staff->user->nama, 0, 1)) }}
                        </span>
                        <span class="dashboard-staff-details">
                            <strong>{{ $staff->user->nama }}</strong>
                            <small>{{ $staff->jabatan->nama }}</small>
                        </span>
                        <span class="dashboard-status"><span></span> Aktif</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="dashboard-staff-empty">
                <span class="dashboard-staff-avatar" aria-hidden="true"><i class="bi bi-people"></i></span>
                <p>Belum ada petugas aktif.</p>
            </div>
        @endif
    </article>
</section>
