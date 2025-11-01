@extends('layouts.backend.admin')

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
        {{-- ផ្លាស់ប្តូរ route ទៅកាន់ product-sub-categories.index (ប្រើ route helper បើអាច) --}}
        <li class="breadcrumb-item"><a href="{{url('admins/sub-category')}}">Product Sub-Categories</a></li>
        <li class="breadcrumb-item active">@lang('lang.edit')</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr ">
                        <h2>
                            ✏️ Edit Product Sub-Category: **{{ $productSubCategory->name }}**
                        </h2>
                    </div>
                    <div class="panel-content">

                        {{-- ផ្លាស់ប្តូរ action route ទៅកាន់ product-sub-categories.update និងបន្ថែម @method('PUT') --}}
                        <form action="{{ url('admins/sub-category', $productSubCategory->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT') {{-- 👈 Required for updating --}}

                            <div class="row">

                                {{-- 1. Product Category ID (Dropdown) --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="product_category_id">Parent Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('product_category_id') is-invalid @enderror" id="product_category_id" name="product_category_id" required>
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{-- ប្រើ old value ឬ existing value ពី model --}}
                                                    {{ old('product_category_id', $productSubCategory->product_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 2. Sub-Category Name --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Sub-Category Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $productSubCategory->name) }}" required
                                            placeholder="Enter Sub-Category Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 3. Serial Number --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="serial_number">Serial Number <span class="text-danger">*</span></label>
                                        <input type="text" id="serial_number" name="serial_number"
                                            class="form-control @error('serial_number') is-invalid @enderror"
                                            value="{{ old('serial_number', $productSubCategory->serial_number) }}" required
                                            placeholder="Enter Unique Serial Number">
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 4. Status (is_active) --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Status (Active/Inactive)</label>
                                        <div>
                                            @php
                                                // យក value ពី old ឬពី model
                                                $statusValue = old('is_active', $productSubCategory->is_active ?? 1);
                                            @endphp
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="is_active_1" name="is_active" class="custom-control-input" value="1" {{ $statusValue == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active_1">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="is_active_0" name="is_active" class="custom-control-input" value="0" {{ $statusValue == 0 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active_0">Inactive</label>
                                            </div>
                                        </div>
                                        @error('is_active')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 5. Description --}}
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Description (Max 200 characters)</label>
                                        <textarea id="description" name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            rows="3"
                                            placeholder="Sub-Category brief description">{{ old('description', $productSubCategory->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Hidden fields for tracking users --}}
                                <input type="hidden" name="updated_by" value="{{ auth()->id() }}">

                            </div>

                            <hr class="mt-4">

                            {{-- Action Buttons --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2" style="text-align: right;">
                                        <a href="{{url('admins/sub-category')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">@lang('lang.cancel')</a>
                                        <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">@lang('lang.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
