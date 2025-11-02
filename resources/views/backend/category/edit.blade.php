@extends('layouts.backend.admin')

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
        {{-- Use the route() helper if possible, or keep the URL --}}
        <li class="breadcrumb-item"><a href="{{ url('admins/category') }}">@lang('lang.category')</a></li>
        <li class="breadcrumb-item active">@lang('lang.edit')</li> {{-- CORRECTED --}}
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr "> {{-- CORRECTED color for Edit --}}
                        <h2>
                            ✏️ Edit Product Category: **{{ $data->name }}** {{-- CORRECTED --}}
                        </h2>
                    </div>
                    <div class="panel-content">

                        {{-- Action is correct for updating (PUT) via URL --}}
                        <form action="{{ url('admins/category', $data->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- 1. Category Name --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $data->name) }}" required {{-- CORRECTED VALUE --}}
                                               placeholder="Enter Category Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 2. Slug (Optional) --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="slug">Slug (Optional)</label>
                                        <input type="text" id="slug" name="slug"
                                               class="form-control @error('slug') is-invalid @enderror"
                                               value="{{ old('slug', $data->slug) }}" {{-- CORRECTED VALUE --}}
                                               placeholder="category-name">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Leave empty to auto-generate from the name.</small>
                                    </div>
                                </div>

                                {{-- 3. Description --}}
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea id="description" name="description"
                                                 class="form-control @error('description') is-invalid @enderror"
                                                 rows="3"
                                                 placeholder="Category brief description">{{ old('description', $data->description) }}</textarea> {{-- CORRECTED VALUE --}}
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 4. Status (is_active) --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Status (Active/Inactive)</label>
                                        @php
                                            // Determine the current value for checking the radio buttons
                                            $isActiveValue = old('is_active', $data->is_active ?? 1); // Use $data->is_active
                                        @endphp
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                {{-- Check if the current value is 1 --}}
                                                <input type="radio" id="is_active_1" name="is_active" class="custom-control-input" value="1" {{ $isActiveValue == 1 ? 'checked' : '' }}> {{-- CORRECTED CHECK --}}
                                                <label class="custom-control-label" for="is_active_1">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                {{-- Check if the current value is 0 --}}
                                                <input type="radio" id="is_active_0" name="is_active" class="custom-control-input" value="0" {{ $isActiveValue == 0 ? 'checked' : '' }}> {{-- CORRECTED CHECK --}}
                                                <label class="custom-control-label" for="is_active_0">Inactive</label>
                                            </div>
                                        </div>
                                        @error('is_active')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-4">

                            {{-- Action Buttons --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2" style="text-align: right;">
                                        {{-- Hidden field for ID is optional if using Route Model Binding, but harmless --}}
                                        <input type="hidden" name="id" value="{{ $data->id}}">
                                        <a href="{{url('admins/category')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">@lang('lang.cancel')</a>
                                        <button type="submit" class="btn btn-outline-warning btn-pills waves-effect waves-themed">@lang('lang.update')</button> {{-- Changed button color and text --}}
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

@section('script')
    <script>

        // Option 1: Live Slug Generation
        // 🚨 កែប្រែ: លុបការត្រួតពិនិត្យ (if) ដើម្បីឲ្យវាបំពេញទៅក្នុង slug field គ្រប់ពេល
        document.getElementById('name').addEventListener('input', function() {
            // បំពេញទៅក្នុង slug field គ្រប់ពេល
            const nameValue = this.value;
            // 1. Lowercase
            // 2. Replace all non-URL-safe characters (except space/hyphen) with nothing
            // 3. Replace spaces with hyphens
            // 4. Collapse multiple hyphens into one
            const slugValue = nameValue.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            document.getElementById('slug').value = slugValue;
        });

        // 🆕 Slug Keypress Restriction (រក្សាទុកដើម្បីការពារការវាយបញ្ចូលដោយដៃ)
        document.getElementById('slug').addEventListener('keypress', function(event) {
            const char = String.fromCharCode(event.which);
            // Regex pattern: allows a-z, 0-9, hyphen (-), and space ( )
            const pattern = /[a-z0-9- ]/;

            // If the character doesn't match the pattern, prevent the keypress
            if (!pattern.test(char)) {
                event.preventDefault();
                return false;
            }
        });
    </script>
@endsection

