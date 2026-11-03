@php
    $color = $color ?? 'green';
    $value = $value ?? '0';
@endphp

<article class="dashboard-stat-card">
    <span class="dashboard-stat-icon {{ $color }}"><i class="bi {{ $icon }}" aria-hidden="true"></i></span>
    <div class="dashboard-stat-copy">
        <span class="dashboard-stat-label">{{ $label }}</span>
        <strong>{{ $value }}</strong>
        <small>{{ $description }}</small>
    </div>
</article>
