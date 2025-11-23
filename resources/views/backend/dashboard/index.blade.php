@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        @php
            $colors = [
                'bg-primary-300',
                'bg-warning-400',
                'bg-success-200',
                'bg-info-200',
                'bg-danger-200',
                'bg-fusion-300',
            ];
        @endphp
        @foreach ($productType as $index => $item)
            @php
                $color = $colors[$index % count($colors)];
            @endphp
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 {{ $color }} rounded overflow-hidden position-relative text-white mb-g">
                    <div>
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $item->products_count }}
                            <small class="m-0 l-h-n">{{ $item->name }}</small>
                        </h3>
                    </div>
                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Marketing profits
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content bg-subtlelight-fade">
                        <div id="js-checkbox-toggles" class="d-flex mb-3">
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-0" id="gra-0" checked="checked">
                                <label class="custom-control-label" for="gra-0">Target Profit</label>
                            </div>
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-1" id="gra-1" checked="checked">
                                <label class="custom-control-label" for="gra-1">Actual Profit</label>
                            </div>
                            <div class="custom-control custom-switch mr-2">
                                <input type="checkbox" class="custom-control-input" name="gra-2" id="gra-2" checked="checked">
                                <label class="custom-control-label" for="gra-2">User Signups</label>
                            </div>
                        </div>
                        <div id="flot-toggles" class="w-100 mt-4" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
