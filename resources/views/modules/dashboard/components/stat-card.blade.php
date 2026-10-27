@php
    $color = $color ?? 'green';
    $value = $value ?? '0';
@endphp

<article class="dashboard-stat-card">
    <span class="dashboard-stat-icon {{ $color }}"><i class="bi {{ $icon }}"></i></span>
    <span class="dashboard-stat-label">{{ $label }}</span>
    <strong>{{ $value }}</strong>
    <small>{{ $description }}</small>
</article>
