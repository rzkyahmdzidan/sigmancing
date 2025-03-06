@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <div class="header-title">
            <h1>Dashboard</h1>
            <p>Selamat datang di SigMancing Admin</p>
        </div>
    </div>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon" style="background: #4f46e5;">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalSpots }}</div>
            <div class="stat-label">Total Spot</div>
            <div class="progress">
                <div class="progress-bar" style="width: 70%; background: #4f46e5;"></div>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #16a34a;">
            <i class="fas fa-store"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalToko }}</div>
            <div class="stat-label">Total Toko</div>
            <div class="progress">
                <div class="progress-bar" style="width: 60%; background: #16a34a;"></div>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #ea580c;">
            <i class="fas fa-fish"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalUmpan }}</div>
            <div class="stat-label">Rekomendasi Umpan</div>
            <div class="progress">
                <div class="progress-bar" style="width: 80%; background: #ea580c;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
