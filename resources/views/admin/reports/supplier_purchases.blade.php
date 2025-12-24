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
    
    .stat-card.spending {
        border-left-color: #10b981;
    }
    
    .stat-card.suppliers {
        border-left-color: #0d6efd;
    }
    
    .stat-card.average {
        border-left-color: #0dcaf0;
    }
    
    .stat-card.top {
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
</style>

<div class="container-fluid px-4 py-5">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex align-items-center gap-4">
            <div class="icon-circle" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <i class="fas fa-truck text-white fa-xl"></i>
            </div>
            <div>
                <h1 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Supplier Spending Report</h1>
                <p class="text-muted mb-0"><i class="fas fa-chart-bar"></i> Total purchases by supplier</p>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    @php
        $grandTotalSpent = $supplierPurchases->sum('total_spent');
        $totalSuppliers = $supplierPurchases->count();
        $topSupplier = $supplierPurchases->first();
        $avgSpentPerSupplier = $totalSuppliers > 0 ? $grandTotalSpent / $totalSuppliers : 0;
    @endphp

    @if(!$supplierPurchases->isEmpty())
        <div class="row g-4 mb-5">
            {{-- Total Spending Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card spending h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="icon-circle bg-success bg-opacity-10">
                                <i class="fas fa-money-bill-wave text-success fa-lg"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-20 text-success small">
                                <i class="fas fa-arrow-up"></i> Total
                            </span>
                        </div>
                        <p class="text-muted mb-2 small fw-semibold">Total Spending</p>
                        <h3 class="fw-bold text-dark mb-3">₨ {{ number_format($grandTotalSpent, 2) }}</h3>
                        <small class="text-success"><i class="fas fa-check-circle"></i> All suppliers combined</small>
                    </div>
                </div>
            </div>

            {{-- Active Suppliers Card --}}
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card suppliers h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="icon-circle bg-primary bg-opacity-10">
                                <i class="fas fa-building text-primary fa-lg"></i>
                            </div>
                            <span class="badge bg-primary">{{ $totalSuppliers }}</span>
                        </div>
                        <p class="text-muted mb-2 small fw-semibold">Active Suppliers</p>
                        <h3 class="fw-bold text-dark mb-3">{{ $totalSuppliers }}</h3>
                        <small class="text-primary"><i class="fas fa-handshake"></i> Supplier count</small>
                    </div>
                </div>
            </div>

            {{-- Average Spending Card --}}
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
                        <p class="text-muted mb-2 small fw-semibold">Avg per Supplier</p>
                        <h3 class="fw-bold text-dark mb-3">₨ {{ number_format($avgSpentPerSupplier, 2) }}</h3>
                        <small class="text-info"><i class="fas fa-info-circle"></i> Average spending</small>
                    </div>
                </div>
            </div>

            {{-- Top Supplier Card --}}
            @if($topSupplier)
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card top h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="icon-circle bg-warning bg-opacity-10">
                                    <i class="fas fa-crown text-warning fa-lg"></i>
                                </div>
                                <span class="badge bg-warning text-dark">🏆 #1</span>
                            </div>
                            <p class="text-muted mb-2 small fw-semibold">Top Supplier</p>
                            <h3 class="fw-bold text-dark mb-3">{{ substr($topSupplier->supplier->name ?? 'N/A', 0, 20) }}</h3>
                            <small class="text-warning"><i class="fas fa-trophy"></i> Most spent with</small>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Charts Row --}}
        <div class="row g-4 mb-5">
            {{-- Bar Chart --}}
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-chart-bar text-primary"></i>
                            Spending by Supplier
                        </h5>
                        <p class="text-muted mb-4">Detailed breakdown of spending per supplier</p>
                        <div style="position: relative; height: 350px;">
                            <canvas id="supplierSpendingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pie Chart --}}
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-pie-chart text-success"></i>
                            Market Share
                        </h5>
                        <p class="text-muted mb-4">Proportional spending distribution</p>
                        <div style="position: relative; height: 350px;">
                            <canvas id="marketShareChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Table --}}
        <div class="card">
            <div class="card-body">
                <h5 class="section-title mb-4">
                    <i class="fas fa-list-ul text-primary"></i>
                    Detailed Supplier Analysis
                </h5>

                <div class="badge bg-primary mb-3">{{ $totalSuppliers }} Suppliers</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> Rank</th>
                                <th><i class="fas fa-building"></i> Supplier Name</th>
                                <th class="text-center"><i class="fas fa-receipt"></i> Invoices</th>
                                <th class="text-end"><i class="fas fa-money-bill"></i> Total Spent</th>
                                <th class="text-center"><i class="fas fa-percent"></i> Market Share</th>
                                <th class="text-center"><i class="fas fa-chart-line"></i> Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplierPurchases as $index => $summary)
                            @php
                                $percentage = ($summary->total_spent / $grandTotalSpent) * 100;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($index == 0)
                                            <span class="badge bg-warning text-dark fw-bold">🏆 1st</span>
                                        @elseif($index == 1)
                                            <span class="badge bg-secondary text-white">🥈 2nd</span>
                                        @elseif($index == 2)
                                            <span class="badge bg-danger bg-opacity-50">🥉 3rd</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon-circle bg-primary bg-opacity-10" style="width: 36px; height: 36px;">
                                            <i class="fas fa-building text-primary"></i>
                                        </div>
                                        <strong>{{ $summary->supplier->name ?? 'Deleted Supplier' }}</strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info bg-opacity-20 text-info fw-semibold">{{ $summary->total_invoices }}</span>
                                </td>
                                <td class="text-end">
                                    <h6 class="fw-bold text-success mb-0">₨ {{ number_format($summary->total_spent, 2) }}</h6>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="fw-bold">{{ number_format($percentage, 1) }}%</span>
                                        <div class="progress" style="width: 80px; height: 6px; border-radius: 3px;">
                                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="fas fa-arrow-{{ $index < 2 ? 'up text-success' : 'down text-muted' }} fa-lg"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info d-flex align-items-center py-5" role="alert">
            <i class="fas fa-info-circle fa-3x me-4"></i>
            <div>
                <h5 class="alert-heading mb-2">No Data Available</h5>
                <p class="mb-0">No purchase history found. Start making purchases to see supplier spending reports.</p>
            </div>
        </div>
    @endif

</div>

{{-- Chart Scripts --}}
@if(!$supplierPurchases->isEmpty())
<script>
    // Prepare data
    const supplierNames = @json($supplierPurchases->map(function($s) { return $s->supplier->name ?? 'Deleted'; }));
    const spendingData = @json($supplierPurchases->pluck('total_spent'));
    const invoiceData = @json($supplierPurchases->pluck('total_invoices'));
    const totalSpent = {{ $grandTotalSpent }};

    // Color palette
    const colors = [
        'rgba(102, 126, 234, 0.85)',
        'rgba(17, 153, 142, 0.85)',
        'rgba(240, 147, 251, 0.85)',
        'rgba(245, 87, 108, 0.85)',
        'rgba(251, 200, 212, 0.85)',
        'rgba(255, 159, 64, 0.85)',
        'rgba(75, 192, 192, 0.85)',
        'rgba(153, 102, 255, 0.85)'
    ];

    // Bar Chart
    const barCtx = document.getElementById('supplierSpendingChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: supplierNames,
                datasets: [{
                label: 'Total Amount Spent (PKR)',
                data: spendingData,
                backgroundColor: colors.slice(0, supplierNames.length),
                borderColor: colors.map(c => c.replace('0.85', '1')).slice(0, supplierNames.length),
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: colors.map(c => c.replace('0.85', '1')).slice(0, supplierNames.length)
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    padding: 14,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    displayColors: false,
                        callbacks: {
                        label: function(context) {
                            return '₨ ' + context.parsed.x.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#e5e7eb' },
                        ticks: {
                            font: { size: 12, weight: '500' },
                            color: '#9ca3af',
                            padding: 8,
                            callback: function(value) {
                                return '₨ ' + value.toFixed(0);
                            }
                        }
                },
                y: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: '#4b5563'
                    }
                }
            }
        }
    });

    // Pie Chart for Market Share
    const pieCtx = document.getElementById('marketShareChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: supplierNames,
            datasets: [{
                data: spendingData,
                backgroundColor: colors.slice(0, supplierNames.length),
                borderColor: '#fff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12, weight: '500' },
                        color: '#4b5563',
                        padding: 15,
                        usePointStyle: true,
                        boxPadding: 6
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    padding: 14,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const percentage = ((context.parsed / totalSpent) * 100).toFixed(1);
                            return '₨ ' + context.parsed.toFixed(2) + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endif

@endsection
