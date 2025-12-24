@extends('layouts.app')

@section('content')

{{-- Font Awesome Icons & Chart.js --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .container-fluid {
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .page-header {
        padding: 2rem 0 2.5rem 0;
        margin-bottom: 2rem;
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .stat-card {
        border-left: 4px solid #667eea;
    }
    
    .stat-card.revenue {
        border-left-color: #10b981;
    }
    
    .stat-card.transactions {
        border-left-color: #0d6efd;
    }
    
    .stat-card.average {
        border-left-color: #0dcaf0;
    }
    
    .stat-card.items {
        border-left-color: #ffc107;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .table thead th {
        background-color: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
        border: none;
        padding: 1.25rem !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table tbody td {
        padding: 1.25rem !important;
        border-color: #e5e7eb;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        width: 48px;
        height: 48px;
    }
    
    .chart-container {
        margin: 2rem 0;
    }
</style>

<div class="container-fluid px-4 py-5">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex align-items-center gap-4">
            <div class="icon-circle bg-gradient-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-chart-line text-white fa-xl"></i>
            </div>
            <div>
                <h1 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Daily Sales Report</h1>
                <p class="text-muted mb-0"><i class="far fa-calendar-alt"></i> {{ today()->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    @php
        $totalRevenue = $dailySales->sum('total_amount');
        $totalSales = $dailySales->count();
        $avgPerTransaction = $totalSales > 0 ? $totalRevenue / $totalSales : 0;
        $totalItems = $dailySales->sum(function($sale) { return $sale->items->sum('qty'); });
    @endphp

    <div class="row g-4 mb-5">
        {{-- Total Revenue Card --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card revenue h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-success bg-opacity-10">
                            <i class="fas fa-money-bill-wave text-success fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-20 text-success small">
                            <i class="fas fa-arrow-up"></i> +5%
                        </span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Total Revenue</p>
                    <h3 class="fw-bold text-dark mb-3">₨ {{ number_format($totalRevenue, 2) }}</h3>
                    <small class="text-success"><i class="fas fa-check-circle"></i> Today's earnings</small>
                </div>
            </div>
        </div>

        {{-- Total Transactions Card --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card transactions h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-primary bg-opacity-10">
                            <i class="fas fa-receipt text-primary fa-lg"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-20 text-primary small">
                            <i class="fas fa-arrow-up"></i> 12
                        </span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Transactions</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $totalSales }}</h3>
                    <small class="text-primary"><i class="fas fa-chart-bar"></i> Sales count</small>
                </div>
            </div>
        </div>

        {{-- Average Per Transaction Card --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card average h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-info bg-opacity-10">
                            <i class="fas fa-calculator text-info fa-lg"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-20 text-info small">
                            <i class="fas fa-equals"></i>
                        </span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Avg per Transaction</p>
                    <h3 class="fw-bold text-dark mb-3">₨ {{ number_format($avgPerTransaction, 2) }}</h3>
                    <small class="text-info"><i class="fas fa-info-circle"></i> Average sale</small>
                </div>
            </div>
        </div>

        {{-- Total Items Card --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card items h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-warning bg-opacity-10">
                            <i class="fas fa-box text-warning fa-lg"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-20 text-warning small">
                            <i class="fas fa-boxes"></i>
                        </span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Items Sold</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $totalItems }}</h3>
                    <small class="text-warning"><i class="fas fa-shopping-cart"></i> Total units</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="section-title mb-4">
                <i class="fas fa-chart-bar text-primary"></i>
                Sales Trend Throughout the Day
            </h5>
            <p class="text-muted mb-4">Hourly breakdown of your sales performance</p>
            <div class="chart-container" style="position: relative; height: 350px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Transactions Table Section --}}
    <div class="card">
        <div class="card-body">
            <h5 class="section-title mb-4">
                <i class="fas fa-list-ul text-primary"></i>
                Transaction Details
            </h5>

            @if($dailySales->isEmpty())
                <div class="alert alert-light border border-secondary-subtle text-center py-5" role="alert">
                    <i class="fas fa-inbox fa-4x mb-3 text-muted opacity-50"></i>
                    <p class="text-muted mb-0">No transactions available for today.</p>
                </div>
            @else
                <div class="badge bg-primary mb-3">{{ $totalSales }} Total Sales</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-clock"></i> Time</th>
                                <th><i class="fas fa-user"></i> Cashier</th>
                                <th><i class="fas fa-shopping-bag"></i> Items</th>
                                <th class="text-end"><i class="fas fa-money-bill"></i> Amount</th>
                                <th class="text-center"><i class="fas fa-credit-card"></i> Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dailySales as $sale)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-20 text-dark fw-semibold">#{{ $sale->id }}</span>
                                    </td>
                                    <td>
                                        <i class="fas fa-clock text-muted me-2"></i>
                                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($sale->created_at)->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-circle bg-primary bg-opacity-10" style="width: 36px; height: 36px;">
                                                <i class="fas fa-user text-primary small"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $sale->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-20 text-info">
                                            <i class="fas fa-boxes me-1"></i> {{ $sale->items->sum('qty') ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <h6 class="fw-bold text-success mb-0">
                                            <i class="fas fa-money-bill-wave"></i>₨ {{ number_format($sale->total_amount ?? $sale->total ?? 0, 2) }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success bg-opacity-20 text-success">
                                            <i class="fas fa-money-bill-wave me-1"></i> Cash
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Chart Script --}}
<script>
    // Group sales by hour
    @php
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourlyData[$i] = 0;
        }
        
        foreach ($dailySales as $sale) {
            $hour = \Carbon\Carbon::parse($sale->created_at)->hour;
            $hourlyData[$hour] += $sale->total_amount;
        }
    @endphp

    const hourlyLabels = [
        '12 AM', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM',
        '6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM',
        '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM',
        '6 PM', '7 PM', '8 PM', '9 PM', '10 PM', '11 PM'
    ];

    const hourlyData = @json(array_values($hourlyData));

    const ctx = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: hourlyLabels,
            datasets: [{
                label: 'Sales Revenue (PKR)',
                data: hourlyData,
                backgroundColor: 'rgba(102, 126, 234, 0.85)',
                borderColor: '#667eea',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(102, 126, 234, 1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: { size: 13, weight: '600' },
                        color: '#4b5563',
                        usePointStyle: true,
                        padding: 20,
                        boxPadding: 8
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    padding: 14,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '₨ ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: '#9ca3af',
                        padding: 8
                    }
                },
                y: {
                    grid: { color: '#e5e7eb', drawBorder: false },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: '#9ca3af',
                        padding: 8,
                        callback: function(value) {
                            return '₨ ' + value.toFixed(0);
                        }
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
