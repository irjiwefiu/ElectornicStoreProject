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
    
    .stat-card.low-stock {
        border-left-color: #ffc107;
    }
    
    .stat-card.zero-stock {
        border-left-color: #dc3545;
    }
    
    .stat-card.health {
        border-left-color: #0dcaf0;
    }
    
    .stat-card.actions {
        border-left-color: #0d6efd;
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
            <div class="icon-circle" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-cube text-white fa-xl"></i>
            </div>
            <div>
                <h1 class="fw-bold text-dark mb-2" style="font-size: 2rem;">Inventory Health Report</h1>
                <p class="text-muted mb-0"><i class="fas fa-exclamation-triangle"></i> Stock levels & alerts</p>
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    @php
        $totalLowStock = $lowStock->count();
        $totalZeroStock = $zeroStock->count();
        $healthScore = $totalLowStock == 0 ? 100 : max(0, 100 - ($totalLowStock * 5));
    @endphp

    <div class="row g-4 mb-5">
        {{-- Low Stock Count --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card low-stock h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-warning bg-opacity-10">
                            <i class="fas fa-exclamation-circle text-warning fa-lg"></i>
                        </div>
                        @if($totalLowStock > 0)
                            <span class="badge bg-warning">
                                <i class="fas fa-arrow-up"></i> Alert
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> OK
                            </span>
                        @endif
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Low Stock Items</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $totalLowStock }}</h3>
                    <small class="text-warning"><i class="fas fa-info-circle"></i> Below minimum level</small>
                </div>
            </div>
        </div>

        {{-- Out of Stock Count --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card zero-stock h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-danger bg-opacity-10">
                            <i class="fas fa-ban text-danger fa-lg"></i>
                        </div>
                        @if($totalZeroStock > 0)
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle"></i> Critical
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> OK
                            </span>
                        @endif
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Out of Stock</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $totalZeroStock }}</h3>
                    <small class="text-danger"><i class="fas fa-exclamation"></i> Zero stock</small>
                </div>
            </div>
        </div>

        {{-- Inventory Health Score --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card health h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-info bg-opacity-10">
                            <i class="fas fa-heartbeat text-info fa-lg"></i>
                        </div>
                        @php
                            $healthColor = $healthScore >= 80 ? 'success' : ($healthScore >= 50 ? 'warning' : 'danger');
                        @endphp
                        <span class="badge bg-{{ $healthColor }}">{{ $healthScore }}%</span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Health Score</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $healthScore }}%</h3>
                    <div class="progress" style="height: 8px; border-radius: 4px;">
                        <div class="progress-bar bg-{{ $healthColor }}" style="width: {{ $healthScore }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Items --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card actions h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="icon-circle bg-primary bg-opacity-10">
                            <i class="fas fa-tasks text-primary fa-lg"></i>
                        </div>
                        <span class="badge bg-primary">{{ $totalLowStock + $totalZeroStock }}</span>
                    </div>
                    <p class="text-muted mb-2 small fw-semibold">Action Required</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $totalLowStock + $totalZeroStock }}</h3>
                    <small class="text-primary"><i class="fas fa-shopping-cart"></i> Items to reorder</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Stock Distribution Chart --}}
    @if($lowStock->isNotEmpty() || $zeroStock->isNotEmpty())
        <div class="card mb-5">
            <div class="card-body">
                <h5 class="section-title mb-4">
                    <i class="fas fa-pie-chart text-primary"></i>
                    Stock Status Distribution
                </h5>
                <p class="text-muted mb-4">Visual breakdown of inventory status</p>
                <div style="position: relative; height: 300px;">
                    <canvas id="stockDistributionChart"></canvas>
                </div>
            </div>
        </div>
    @endif

    {{-- Low Stock Table --}}
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="section-title mb-4">
                <i class="fas fa-exclamation-circle text-warning"></i>
                Low Stock Items
            </h5>

            @if($lowStock->isEmpty())
                <div class="alert alert-success d-flex align-items-center py-4" role="alert">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <strong>Great!</strong> All products are currently above their minimum stock levels.
                    </div>
                </div>
            @else
                <div class="badge bg-warning bg-opacity-20 text-warning mb-3">{{ $lowStock->count() }} Items</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-barcode"></i> SKU</th>
                                <th><i class="fas fa-box"></i> Product</th>
                                <th><i class="fas fa-tag"></i> Category</th>
                                <th><i class="fas fa-truck"></i> Supplier</th>
                                <th class="text-center"><i class="fas fa-boxes"></i> Current</th>
                                <th class="text-center"><i class="fas fa-line-chart"></i> Min Level</th>
                                <th class="text-center"><i class="fas fa-plus-circle"></i> Suggested Qty</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStock as $product)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark fw-semibold">{{ $product->sku }}</span>
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <i class="fas fa-building text-muted me-2"></i>{{ $product->supplier->name ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger bg-opacity-10 text-danger fw-semibold">
                                        {{ $product->stock_qty }}
                                    </span>
                                </td>
                                <td class="text-center fw-semibold">{{ $product->min_stock }}</td>
                                <td class="text-center">
                                    <strong class="text-primary">{{ $product->min_stock * 2 }}</strong>
                                </td>
                                <td class="text-center">
                                    @php
                                        $stockPercent = ($product->stock_qty / $product->min_stock) * 100;
                                        $statusColor = $stockPercent == 0 ? 'danger' : 'warning';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} bg-opacity-20 text-{{ $statusColor }}">
                                        {{ round($stockPercent) }}%
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

    {{-- Out of Stock Table --}}
    <div class="card">
        <div class="card-body">
            <h5 class="section-title mb-4">
                <i class="fas fa-ban text-danger"></i>
                Out of Stock Products
            </h5>

            @if($zeroStock->isEmpty())
                <div class="alert alert-info d-flex align-items-center py-4" role="alert">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <strong>Excellent!</strong> No products are completely out of stock.
                    </div>
                </div>
            @else
                <div class="badge bg-danger bg-opacity-20 text-danger mb-3">{{ $zeroStock->count() }} Items</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-barcode"></i> SKU</th>
                                <th><i class="fas fa-box"></i> Product</th>
                                <th><i class="fas fa-truck"></i> Last Supplier</th>
                                <th class="text-center"><i class="fas fa-alert-circle"></i> Status</th>
                                <th class="text-center"><i class="fas fa-calendar"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zeroStock as $product)
                                <tr>
                                    <td>
                                        <span class="badge bg-danger text-white fw-semibold">{{ $product->sku }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-danger">{{ $product->name }}</strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-building text-muted me-2"></i>{{ $product->supplier->name ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i> OUT OF STOCK
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger fw-semibold">
                                            <i class="fas fa-shopping-cart me-1"></i> Order
                                        </button>
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

{{-- Stock Distribution Chart Script --}}
<script>
    @if($lowStock->isNotEmpty() || $zeroStock->isNotEmpty())
        const stockCtx = document.getElementById('stockDistributionChart').getContext('2d');
        
        new Chart(stockCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [{{ $lowStock->count() }}, {{ $zeroStock->count() }}],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.85)',
                        'rgba(220, 53, 69, 0.85)'
                    ],
                    borderColor: [
                        '#ffc107',
                        '#dc3545'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 13, weight: '600' },
                            color: '#4b5563',
                            padding: 20,
                            usePointStyle: true,
                            boxPadding: 8
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
                                return context.label + ': ' + context.parsed + ' items';
                            }
                        }
                    }
                }
            }
        });
    @endif
</script>

@endsection
