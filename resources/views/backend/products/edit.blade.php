@extends('layouts.backend.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-11">
        <div id="panel-2" class="panel border-0 shadow-sm" style="border-radius: 18px;">
            <div class="panel-hdr bg-white border-bottom p-4 d-flex align-items-center justify-content-between" style="min-height: 70px;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-light text-primary p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="fal fa-edit fs-xl"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-dark" style="font-size: 18px;">Edit Product #{{ $data->id }}</h2>
                        <span class="text-muted fs-xs">Update product specifications, pricing, stock, and media</span>
                    </div>
                </div>
                <div>
                    <a href="{{ url('admins/product') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 font-weight-bold">
                        <i class="fal fa-arrow-left mr-1"></i> Back to Products
                    </a>
                </div>
            </div>

            <div class="panel-container show">
                <div class="panel-content p-4 p-md-5">
                    <form method="POST" action="{{ url('admins/product',$data->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Basic Information -->
                        <div class="form-section-divider">
                            <h6><i class="fal fa-info-circle text-primary mr-1"></i> Basic Product Information</h6>
                            <p>Primary details, product title, and description</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name', $data->name) }}" required>
                                    @if($errors->has('name'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('name') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">URL Slug <span class="text-muted fs-nano font-weight-normal">(Optional)</span></label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="product-slug" value="{{ old('slug', $data->slug) }}">
                                    <small class="form-text text-muted">Leave empty to auto-generate from product name.</small>
                                    @if($errors->has('slug'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('slug') !!}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Detailed Description</label>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="description">{{ old('description', $data->description) }}</textarea>
                        </div>

                        <div id="alert-message" class="alert" style="display:none; margin-bottom: 15px;"></div>

                        <!-- Section 2: Media & Images -->
                        <div class="form-section-divider">
                            <h6><i class="fal fa-images text-primary mr-1"></i> Product Photos & Gallery</h6>
                            <p>Manage current photo assets and gallery preview</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_photo">Main Feature Photo</label>
                                    <input type="file" name="product_photo" class="form-control p-2" id="image-input" accept="image/*">
                                    @if($errors->has('product_photo'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('product_photo') !!}</small>
                                    @endif
                                    <div id="photo-preview" class="mt-3">
                                        @if ($data->product_photo)
                                            <div id="main-photo-container" class="d-flex align-items-center bg-light p-2 rounded" style="gap: 12px; border: 1px solid #e2e8f0; max-width: 250px;">
                                                <img id="main-product-photo" src="{{ $data->product_photo ? 'https://cdn.cmautoservic.com/' . $data->product_photo : asset('images/default.png') }}"
                                                    style="object-fit: cover; width: 80px; height: 50px; border-radius: 6px;" alt="product photo">
                                                <a href="#" class="btn btn-xs btn-outline-danger rounded-pill delete-photo font-weight-bold"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('product.delete_photo', $data->id) }}">
                                                    <i class="fal fa-trash-alt"></i> Remove
                                                </a>
                                            </div>
                                        @else
                                            <p id="main-photo-placeholder" class="text-muted fs-xs font-italic mb-0">No main photo currently set.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gallery">Add More Gallery Images</label>
                                    <input type="file" name="gallery[]" class="form-control p-2" multiple accept="image/*">
                                    <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3">
                                        @forelse ($data->productImage as $item)
                                            <div id="gallery-image-{{ $item->id }}" style="position: relative; width: 80px; height: 55px; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1;">
                                                <img
                                                    src="{{ $item->full_url }}"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    alt="product image"
                                                >
                                                <a href="#"
                                                class="delete-gallery-image"
                                                data-id="{{ $item->id }}"
                                                data-url="{{ route('product.delete_gallery_image', $item->id) }}"
                                                style="position: absolute; top: 2px; right: 2px; background: rgba(225, 29, 72, 0.9); color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; text-decoration: none; cursor: pointer;">
                                                    ✕
                                                </a>
                                            </div>
                                        @empty
                                            <p id="gallery-placeholder" class="text-muted fs-xs font-italic mb-0">No gallery images currently set.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Pricing & Inventory -->
                        <div class="form-section-divider">
                            <h6><i class="fal fa-tags text-primary mr-1"></i> Pricing & Inventory Control</h6>
                            <p>Set price, discounts, part numbers, and stock warnings</p>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Regular Price ($)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light text-muted font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="0.00" value="{{ $data->price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="discount_price">Discount Price ($)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light text-muted font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" name="discount_price" id="discount_price" placeholder="0.00" value="{{ $data->discount_price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="low_stock_qty_warning">Low Stock Alert Qty</label>
                                    <input type="number" class="form-control" name="low_stock_qty_warning" id="low_stock_qty_warning" placeholder="e.g. 5" value="{{ old('low_stock_qty_warning') ?? $data->low_stock_qty_warning }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Stock Status</label>
                                    <select class="form-control select2" name="status" id="status">
                                        <option value="0" {{ old('status', $data->status) == 0 ? 'selected' : '' }}>In Stock (មានស្តុក)</option>
                                        <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }}>Out of Stock (អស់ស្តុក)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Classification & Vehicle Fitment -->
                        <div class="form-section-divider">
                            <h6><i class="fal fa-car text-primary mr-1"></i> Vehicle Fitment & Categorization</h6>
                            <p>Specify make, model, year, engine, and product type</p>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Make (Brand) <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="category_id" name="category_id">
                                        <option value="">Please choose make</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $data->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('category_id'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('category_id') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sub_category_id">Model <span class="text-danger">*</span></label>
                                    <select class="form-control sub_category select2" id="sub_category_id" name="sub_category_id">
                                        <option value="">Please choose model</option>
                                        @foreach($sub_category as $item)
                                            <option value="{{ $item->id }}" {{ $data->sub_category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_category_id'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('sub_category_id') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="engine_id">Engine Specs</label>
                                    <select class="form-control engine_id select2" id="engine_id" name="engine_id">
                                        <option value="">Please choose engine</option>
                                        @foreach($engine as $item)
                                            <option value="{{ $item->id }}" {{ $data->engine_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_type_id">Product Type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_type_id">
                                        <option value="">Please choose product type</option>
                                        @foreach ($producttype as $item)
                                            <option value="{{ $item->id }}" {{ $data->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('product_type_id'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('product_type_id') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="year">Model Year</label>
                                    <select class="form-control select2" name="year" id="year">
                                        <option value="">Select year...</option>
                                        @php
                                            $startYear = 2000;
                                            $endYear = date('Y') + 10;
                                        @endphp
                                        @for ($y = $startYear; $y <= $endYear; $y++)
                                            <option value="{{ $y }}" {{ $data->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number">Part Number / SKU</label>
                                    <input type="text" class="form-control" name="number" id="number" placeholder="e.g. PN-99482-B" value="{{ $data->number }}">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions Bar -->
                        <div class="d-flex align-items-center justify-content-end pt-4 mt-4 border-top" style="gap: 12px;">
                            <input type="text" id="id" name="id" value="{{ $data->id }}" hidden>
                            <a href="{{url('admins/product')}}" class="btn btn-light rounded-pill px-4 font-weight-bold text-muted">Cancel</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary rounded-pill px-5 shadow-sm font-weight-bold" style="height: 44px;">
                                <i class="fal fa-save mr-1"></i> Update Product
                            </button>
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
        $(function(){
            $('.js-summernote').summernote({
                height: 200,               // editor height
                placeholder: 'Write your content here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $(document).on('change','#profile', function() {
                if (this.files && this.files[0]) {
                    let img = document.querySelector('.image_preview');
                    img.onload = () =>{
                        URL.revokeObjectURL(img.src);
                    }
                    img.src = URL.createObjectURL(this.files[0]);
                    document.querySelector(".image_preview").files = this.files;
                }
            });
            $(document).ready(function() {
            // Function to display a temporary alert message
            function showAlert(message, type = 'success') {
                const alertBox = $('#alert-message');
                alertBox.removeClass('alert-success alert-info').addClass(`alert-${type}`).text(message).fadeIn();
                setTimeout(() => alertBox.fadeOut(), 3000);
            }

            // --- Main Product Photo Deletion ---
            $('.delete-photo').on('click', function(e) {
                e.preventDefault();

                if (!confirm('Are you sure you want to remove the main photo?')) {
                    return;
                }

                const url = $(this).data('url');

                $.ajax({
                    url: url,
                    type: 'DELETE', // Use DELETE method, best practice for deletion
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // Pass CSRF token
                    },
                    success: function(response) {
                        // Hide the photo and the "Remove" link
                        $('#main-photo-container').remove();
                        // Add the placeholder text
                        $('#photo-preview').append('<p id="main-photo-placeholder">No main photo currently set.</p>');
                        showAlert(response.message || 'Main photo removed successfully.', 'success');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        showAlert('An error occurred while removing the main photo.', 'danger');
                    }
                });
            });

            // --- Gallery Image Deletion ---
            $('.delete-gallery-image').on('click', function(e) {
                e.preventDefault();

                if (!confirm('Are you sure you want to delete this gallery image?')) {
                    return;
                }

                const id = $(this).data('id');
                const url = $(this).data('url');

                $.ajax({
                    url: url,
                    type: 'DELETE', // Use DELETE method, best practice for deletion
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Remove the image element from the DOM
                        $('#gallery-image-' + id).remove();

                        // You might want to check if the gallery is now empty and add a placeholder

                        showAlert(response.message || 'Gallery image deleted successfully.', 'success');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        showAlert('An error occurred while deleting the gallery image.', 'danger');
                    }
                });
            });
        });
             $(document).on('change','#category_id',function(){
                var category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('admins/product/category/onchange') }}",
                    data: {
                        category_id:category_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $(".sub_category").empty();
                        $(".sub_category").empty().append('<option value="">Please Select</option>');
                        $.each(response.data, function(index, item)
                        {
                            $(".sub_category").append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    }
                });
            });
            $(document).on('change','#sub_category_id',function(){
                var sub_category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('admins/product/sub-category/onchange') }}",
                    data: {
                        sub_category_id:sub_category_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $(".engine_id").empty();
                        $(".engine_id").empty().append('<option value="">Please Select</option>');
                        $.each(response.data, function(index, item)
                        {
                            $(".engine_id").append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    }
                });
            });

            // Live Slug Generation from Make, Model, Engine, Product Type, Name, Number
            function generateAutoSlug() {
                let parts = [];

                let makeText = $('#category_id option:selected').text();
                if (makeText && !makeText.toLowerCase().includes('choose') && !makeText.toLowerCase().includes('select')) {
                    parts.push(makeText.trim());
                }

                let modelText = $('#sub_category_id option:selected').text();
                if (modelText && !modelText.toLowerCase().includes('choose') && !modelText.toLowerCase().includes('select')) {
                    parts.push(modelText.trim());
                }

                let engineText = $('#engine_id option:selected').text();
                if (engineText && !engineText.toLowerCase().includes('choose') && !engineText.toLowerCase().includes('select')) {
                    parts.push(engineText.trim());
                }

                let typeText = $('select[name="product_type_id"] option:selected').text();
                if (typeText && !typeText.toLowerCase().includes('choose') && !typeText.toLowerCase().includes('select')) {
                    parts.push(typeText.trim());
                }

                let nameVal = $('#name').val();
                if (nameVal) {
                    parts.push(nameVal.trim());
                }

                let numVal = $('#number').val();
                if (numVal) {
                    parts.push(numVal.trim());
                }

                let rawString = parts.join(' ');
                let slugValue = rawString.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');

                $('#slug').val(slugValue);
            }

            $(document).on('change input', '#category_id, #sub_category_id, #engine_id, select[name="product_type_id"], #name, #number', function() {
                generateAutoSlug();
            });

            const slugEl = document.getElementById('slug');
            if (slugEl) {
                slugEl.addEventListener('keypress', function(event) {
                    const char = String.fromCharCode(event.which);
                    const pattern = /[a-z0-9- ]/;
                    if (!pattern.test(char)) {
                        event.preventDefault();
                        return false;
                    }
                });
            $(document).ready(function() {
                $('form').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    var btn = $('#submit-btn');
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

                    var formData = new FormData(form);

                    $.ajax({
                        type: 'POST',
                        url: $(form).attr('action'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(res) {
                            btn.prop('disabled', false).html('<i class="fal fa-save mr-1"></i> Update Product');
                            if (typeof toastr !== 'undefined') {
                                toastr.success(res.message || 'Product updated successfully!');
                            }
                            if (res.redirect) {
                                setTimeout(function() {
                                    window.location.href = res.redirect;
                                }, 800);
                            }
                        },
                        error: function(err) {
                            btn.prop('disabled', false).html('<i class="fal fa-save mr-1"></i> Update Product');
                            var msg = 'Product update failed. Please check form inputs.';
                            if (err.responseJSON && err.responseJSON.message) {
                                msg = err.responseJSON.message;
                            }
                            if (typeof toastr !== 'undefined') {
                                toastr.error(msg);
                            } else {
                                alert(msg);
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
