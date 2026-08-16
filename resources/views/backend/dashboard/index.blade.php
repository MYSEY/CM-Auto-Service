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
        font-size: 32px;
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
        font-size: 4.5rem;
        opacity: 0.18;
    }
</style>

<div class="subheader mb-4">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-chart-area'></i> Admin <span class='fw-300'>Dashboard Overview</span>
    </h1>
</div>

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

<div class="row mt-2">
    <div class="col-lg-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <i class="fal fa-chart-line mr-2 text-primary"></i> Analytics & Sales Overview
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content bg-subtlelight-fade p-4">
                    <div id="js-checkbox-toggles" class="d-flex mb-3" style="gap: 16px;">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="gra-0" id="gra-0" checked="checked">
                            <label class="custom-control-label font-weight-bold text-secondary" for="gra-0">Target Profit</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="gra-1" id="gra-1" checked="checked">
                            <label class="custom-control-label font-weight-bold text-secondary" for="gra-1">Actual Profit</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="gra-2" id="gra-2" checked="checked">
                            <label class="custom-control-label font-weight-bold text-secondary" for="gra-2">User Signups</label>
                        </div>
                    </div>
                    <div id="flot-toggles" class="w-100 mt-4" style="height: 320px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
