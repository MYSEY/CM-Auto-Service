@extends('layouts.backend.admin')

@section('content')
<style>
    .stat-card {
        border-radius: 16px;
        padding: 22px 24px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease;
        margin-bottom: 24px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15);
    }

    .stat-card-gradient-1 { background: linear-gradient(135deg, #17005e 0%, #3b00bb 100%); }
    .stat-card-gradient-2 { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }
    .stat-card-gradient-3 { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
    .stat-card-gradient-4 { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); }
    .stat-card-gradient-5 { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
    .stat-card-gradient-6 { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); }

    .stat-count {
        font-size: 30px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 4px;
    }

    .stat-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        opacity: 0.9;
    }

    .stat-icon {
        position: absolute;
        right: 18px;
        bottom: 12px;
        font-size: 4.2rem;
        opacity: 0.18;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        transition: all 0.25s ease;
        margin-bottom: 24px;
    }

    .kpi-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        transform: translateY(-2px);
    }

    .kpi-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .kpi-icon-primary { background: #e0e7ff; color: #4338ca; }
    .kpi-icon-success { background: #d1fae5; color: #059669; }
    .kpi-icon-warning { background: #fef3c7; color: #d97706; }
    .kpi-icon-info { background: #e0f2fe; color: #0284c7; }

    .kpi-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .kpi-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }
</style>

<div class="subheader mb-4 d-flex justify-content-between align-items-center">
    <h1 class="subheader-title mb-0">
        <i class='subheader-icon fal fa-chart-area text-primary'></i> Admin <span class='fw-300'>Dashboard Overview</span>
    </h1>
    <div class="d-flex gap-2">
        <span class="badge badge-primary p-2 px-3 fs-sm shadow-sm" style="border-radius: 30px;">
            <i class="fal fa-calendar-alt mr-1"></i> Live Real-Time Analytics
        </span>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon-box kpi-icon-success">
                <i class="fal fa-usd-circle"></i>
            </div>
            <div>
                <div class="kpi-value">${{ number_format($totalRevenue, 2) }}</div>
                <div class="kpi-label">Total Gross Revenue</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon-box kpi-icon-primary">
                <i class="fal fa-shopping-cart"></i>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($totalSellsCount) }}</div>
                <div class="kpi-label">POS Sales Transactions</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon-box kpi-icon-warning">
                <i class="fal fa-file-invoice"></i>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($totalOrdersCount) }}</div>
                <div class="kpi-label">E-Commerce Orders</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon-box kpi-icon-info">
                <i class="fal fa-users"></i>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($totalUsers) }}</div>
                <div class="kpi-label">Registered Customers</div>
            </div>
        </div>
    </div>
</div>

<!-- Product Type Inventory Stat Cards -->
<div class="row">
    @php
        $gradients = [
            'stat-card-gradient-1',
            'stat-card-gradient-2',
            'stat-card-gradient-3',
            'stat-card-gradient-4',
            'stat-card-gradient-5',
            'stat-card-gradient-6',
        ];
        $icons = [
            'fal fa-boxes',
            'fal fa-file-alt',
            'fal fa-wrench',
            'fal fa-car',
            'fal fa-tags',
            'fal fa-cubes'
        ];
    @endphp

    @foreach ($productType as $index => $item)
        @php
            $gradientClass = $gradients[$index % count($gradients)];
            $iconClass = $icons[$index % count($icons)];
        @endphp
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card {{ $gradientClass }}">
                <div class="stat-count">{{ number_format($item->products_count) }}</div>
                <div class="stat-title">{{ $item->name }}</div>
                <i class="{{ $iconClass }} stat-icon"></i>
            </div>
        </div>
    @endforeach
</div>

<!-- Analytics & Sales Overview Panel -->
<div class="row mt-2">
    <div class="col-lg-8">
        <div id="panel-1" class="panel h-100">
            <div class="panel-hdr d-flex justify-content-between align-items-center">
                <h2>
                    <i class="fal fa-chart-line mr-2 text-primary"></i> Analytics & Sales Overview
                </h2>
                <div class="panel-toolbar">
                    <span class="text-muted fs-xs font-weight-bold">Last 12 Months Trend</span>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content bg-subtlelight-fade p-4">
                    <div id="js-checkbox-toggles" class="d-flex flex-wrap mb-3" style="gap: 20px;">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="toggle-sales" checked>
                            <label class="custom-control-label font-weight-bold text-dark" for="toggle-sales">
                                <span class="badge badge-pill badge-primary mr-1">&nbsp;</span> Sales Revenue ($)
                            </label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="toggle-orders" checked>
                            <label class="custom-control-label font-weight-bold text-dark" for="toggle-orders">
                                <span class="badge badge-pill badge-success mr-1">&nbsp;</span> Total Orders
                            </label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="toggle-signups" checked>
                            <label class="custom-control-label font-weight-bold text-dark" for="toggle-signups">
                                <span class="badge badge-pill badge-warning mr-1">&nbsp;</span> User Signups
                            </label>
                        </div>
                    </div>
                    <div id="main-analytics-chart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Distribution Chart -->
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-hdr">
                <h2>
                    <i class="fal fa-pie-chart mr-2 text-info"></i> Inventory Distribution
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-4 d-flex flex-column align-items-center justify-content-center">
                    <div id="type-donut-chart" class="w-100" style="min-height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Section -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-hdr d-flex justify-content-between align-items-center">
                <h2>
                    <i class="fal fa-cash-register mr-2 text-success"></i> Recent POS Sales
                </h2>
                <a href="{{ route('sell.index') }}" class="btn btn-xs btn-outline-primary fw-600">View All</a>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentSells as $sell)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $sell->invoice_no }}</td>
                                        <td>{{ $sell->customer_name ?? 'Walk-in Customer' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sell->sell_date)->format('M d, Y') }}</td>
                                        <td class="font-weight-bold">${{ number_format($sell->grand_total, 2) }}</td>
                                        <td>
                                            @if($sell->status == 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($sell->status == 'partial')
                                                <span class="badge badge-warning">Partial</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($sell->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fal fa-inbox fa-2x mb-2 d-block"></i> No recent POS sales recorded
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-hdr d-flex justify-content-between align-items-center">
                <h2>
                    <i class="fal fa-shopping-bag mr-2 text-warning"></i> Recent Orders
                </h2>
                <a href="{{ route('order.index') }}" class="btn btn-xs btn-outline-primary fw-600">View All</a>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped m-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Qty</th>
                                    <th>Order Date</th>
                                    <th>Total ($)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                    <tr>
                                        <td class="font-weight-bold text-primary">#ORD-{{ $order->id }}</td>
                                        <td>{{ $order->quantity }} items</td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                                        <td class="font-weight-bold">${{ number_format($order->sub_total, 2) }}</td>
                                        <td>
                                            @if($order->status == 'completed' || $order->status == 'paid')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fal fa-inbox fa-2x mb-2 d-block"></i> No recent orders recorded
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var monthCategories = {!! json_encode($months) !!};
        var salesRevenue = {!! json_encode($salesData) !!};
        var ordersCount = {!! json_encode($ordersData) !!};
        var userSignups = {!! json_encode($signupsData) !!};

        var typeNames = {!! json_encode($typeNames) !!};
        var typeCounts = {!! json_encode($typeCounts) !!};

        // 1. MAIN ANALYTICS CHART
        var mainChartOptions = {
            series: [
                {
                    name: 'Sales Revenue ($)',
                    type: 'area',
                    data: salesRevenue
                },
                {
                    name: 'Total Orders',
                    type: 'line',
                    data: ordersCount
                },
                {
                    name: 'User Signups',
                    type: 'line',
                    data: userSignups
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                },
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            stroke: {
                width: [3, 3, 3],
                curve: 'smooth',
                dashArray: [0, 0, 4]
            },
            colors: ['#4f46e5', '#10b981', '#f59e0b'],
            fill: {
                type: ['gradient', 'solid', 'solid'],
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.25,
                    gradientToColors: ['#818cf8'],
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            labels: monthCategories,
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            },
            xaxis: {
                type: 'category',
                labels: {
                    style: {
                        colors: '#64748b',
                        fontWeight: 600
                    }
                }
            },
            yaxis: [
                {
                    title: {
                        text: 'Sales Revenue ($)',
                        style: { color: '#4f46e5', fontWeight: 700 }
                    },
                    labels: {
                        formatter: function (val) {
                            return "$" + Number(val).toLocaleString();
                        },
                        style: { colors: '#4f46e5' }
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: 'Orders / Signups Count',
                        style: { color: '#10b981', fontWeight: 700 }
                    },
                    labels: {
                        formatter: function (val) {
                            return Number(val).toFixed(0);
                        },
                        style: { colors: '#10b981' }
                    }
                }
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y, { seriesIndex }) {
                        if (typeof y !== "undefined" && y !== null) {
                            if (seriesIndex === 0) return "$" + Number(y).toFixed(2);
                            return Number(y).toFixed(0) + " units";
                        }
                        return y;
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontWeight: 600
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            }
        };

        var mainChart = new ApexCharts(document.querySelector("#main-analytics-chart"), mainChartOptions);
        mainChart.render();

        // Checkbox toggles
        document.getElementById('toggle-sales').addEventListener('change', function() {
            mainChart.toggleSeries('Sales Revenue ($)');
        });
        document.getElementById('toggle-orders').addEventListener('change', function() {
            mainChart.toggleSeries('Total Orders');
        });
        document.getElementById('toggle-signups').addEventListener('change', function() {
            mainChart.toggleSeries('User Signups');
        });

        // 2. DONUT INVENTORY DISTRIBUTION CHART
        var donutOptions = {
            series: typeCounts.length > 0 ? typeCounts : [1],
            labels: typeNames.length > 0 ? typeNames : ['No Inventory Data'],
            chart: {
                type: 'donut',
                height: 320,
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#4f46e5', '#0284c7', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            legend: {
                position: 'bottom',
                fontWeight: 600
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Stock',
                                fontSize: '14px',
                                fontWeight: 700,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 280 },
                    legend: { position: 'bottom' }
                }
            }]
        };

        var donutChart = new ApexCharts(document.querySelector("#type-donut-chart"), donutOptions);
        donutChart.render();
    });
</script>
@endsection
