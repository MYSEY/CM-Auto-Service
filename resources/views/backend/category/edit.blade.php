@extends('layouts.backend.admin')

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item"><a href="{{ url('admins/category') }}">@lang('lang.category')</a></li>
        <li class="breadcrumb-item active">@lang('lang.edit')</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr ">
                        <h2>
                            ✏️ Edit Product Category: <b>{{ $data->name }}</b>
                        </h2>
                    </div>
                    <div class="panel-content">
                        {{-- REQUIRED: Container for the AJAX success/error message --}}
                        <div id="alert-message" class="alert" style="display:none;" role="alert"></div>

                        <form action="{{ url('admins/category', $data->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')
                            {{-- CSRF Token for AJAX (kept here for easy reference, but the meta tag is used by AJAX) --}}
                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class="row">
                                {{-- 1. Category Name --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $data->name) }}" required
                                            placeholder="Enter Category Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- 2. Slug --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="slug">Slug <span class="text-danger">*</span></label>
                                        <input type="text" id="slug" name="slug"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            value="{{ old('slug', $data->slug) }}"
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
                                                 placeholder="Category brief description">{{ old('description', $data->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="col-md-12">

                                {{-- 4. Photo Upload and Preview --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="category_photo">Photo</label>
                                        <input type="file" name="category_photo" class="form-control @error('category_photo') is-invalid @enderror" id="image-input">
                                        @error('category_photo')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Max 2MB. Recommended dimensions: 100x50 pixels.</small>

                                        <div id="photo-preview" style="margin-top:10px;">
                                            @if ($data->category_photo)
                                                <div id="main-photo-container" style="display:flex; align-items:center; gap: 8px;">
                                                    <img id="main-product-photo" src="{{ asset('images/category/' . $data->category_photo) }}"
                                                         style="object-fit: cover; width: 100px; height: 50px;" alt="category photo">

                                                    {{-- AJAX REMOVE MAIN PHOTO LINK (Use correct route) --}}
                                                    <a href="#" class="text-danger delete-photo"
                                                       data-id="{{ $data->id }}"
                                                       data-url="{{ route('productcate.delete_photo', $data->id) }}">
                                                        Remove Photo
                                                    </a>
                                                </div>
                                            @else
                                                <p id="main-photo-placeholder">No main photo currently set.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- 5. Status (is_active) --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Status (Active/Inactive) <span class="text-danger">*</span></label>
                                        @php
                                            $isActiveValue = old('is_active', $data->is_active ?? 1);
                                        @endphp
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="is_active_1" name="is_active" class="custom-control-input" value="1" {{ $isActiveValue == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active_1">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="is_active_0" name="is_active" class="custom-control-input" value="0" {{ $isActiveValue == 0 ? 'checked' : '' }}>
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
                                        <input type="hidden" name="id" value="{{ $data->id}}">
                                        <a href="{{url('admins/category')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">@lang('lang.cancel')</a>
                                        <button type="submit" class="btn btn-outline-warning btn-pills waves-effect waves-themed">@lang('lang.update')</button>
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
        // 1. Live Slug Generation
        document.getElementById('name').addEventListener('input', function() {
            const nameValue = this.value;
            // Simplified Slug generation (good for basic Roman characters)
            const slugValue = nameValue
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '') // Remove non-safe characters
                .replace(/\s+/g, '-')       // Replace spaces with hyphens
                .replace(/-+/g, '-');       // Collapse multiple hyphens

            document.getElementById('slug').value = slugValue;
        });

        // 2. jQuery for AJAX Photo Removal
        $(document).ready(function() {
            // Function to display a temporary alert message (using your provided structure)
            function showAlert(message, type = 'success') {
                const alertBox = $('#alert-message');
                // Hide alert, change classes, set message, then show.
                alertBox.hide().removeClass('alert-success alert-danger').addClass(`alert-${type}`).text(message).fadeIn();

                // Hide after 3 seconds, or use Toastr directly if available globally
                if (typeof toastr !== 'undefined') {
                    if(type === 'success') {
                        toastr.success(message);
                    } else {
                        toastr.error(message);
                    }
                    alertBox.hide(); // Hide custom alert if Toastr is used
                } else {
                    setTimeout(() => alertBox.fadeOut(), 3000);
                }
            }


        // Event listener for the "Remove Photo" link
        $('.delete-photo').on('click', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to remove the category photo?')) {
                return;
            }

            const url = $(this).data('url');
            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: 'POST', // Spoofing DELETE method
                data: {
                    _token: token,
                    _method: 'DELETE' // Method spoofing
                },
                success: function(response) {
                    if (response.success) {
                        // 1. Remove the image and the link container
                        $('#main-photo-container').remove();

                        // 2. Add the placeholder text
                        $('#photo-preview').append(
                            '<p id="main-photo-placeholder">No main photo currently set.</p>'
                        );

                        // 3. Display success message (using Toastr)
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message || 'Photo removed successfully.');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.error || 'Failed to remove photo.');
                        }
                    }
                },
                error: function(xhr) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('An error occurred during the request.');
                    }
                    console.error("AJAX Error:", xhr.responseText);
                }
            });
        });
    });
    </script>
@endsection
