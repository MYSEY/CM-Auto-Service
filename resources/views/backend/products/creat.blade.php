@extends('layouts.backend.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-11">
        <div id="panel-2" class="panel border-0 shadow-sm" style="border-radius: 18px;">
            <div class="panel-hdr bg-white border-bottom p-4 d-flex align-items-center justify-content-between" style="min-height: 70px;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-light text-primary p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="fal fa-plus-circle fs-xl"></i>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-dark" style="font-size: 18px;">Create New Product</h2>
                        <span class="text-muted fs-xs">Add a new item to your auto service inventory & catalog</span>
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
                    <form method="POST" action="{{ url('admins/product') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Section 1: Basic Information -->
                        <div class="form-section-divider">
                            <h6><span class="figma-step-number">01</span> Basic Product Information</h6>
                            <p>Primary details, product title, and description</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Engine Oil Filter 5W-30" value="{{ old('name') }}" required>
                                    @if($errors->has('name'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('name') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">URL Slug <span class="text-muted fs-nano font-weight-normal">(Optional)</span></label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="e.g. engine-oil-filter-5w-30" value="{{ old('slug') }}">
                                    <small class="form-text text-muted">Leave empty to auto-generate from product name.</small>
                                    @if($errors->has('slug'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('slug') !!}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Detailed Description</label>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="description">{{ old('description') }}</textarea>
                        </div>

                        <!-- Section 2: Media & Images -->
                        <div class="form-section-divider">
                            <h6><span class="figma-step-number">02</span> Product Photos & Gallery</h6>
                            <p>Upload main photo and supplementary gallery images</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_photo">Main Feature Photo</label>
                                    <div class="figma-dropzone">
                                        <i class="fal fa-cloud-upload fa-2x text-primary mb-2 d-block"></i>
                                        <span class="font-weight-bold text-dark fs-xs d-block mb-1">Click to select main photo</span>
                                        <input type="file" name="product_photo" class="form-control-file d-block mx-auto" id="image-input" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gallery">Product Gallery Images</label>
                                    <div class="figma-dropzone">
                                        <i class="fal fa-images fa-2x text-info mb-2 d-block"></i>
                                        <span class="font-weight-bold text-dark fs-xs d-block mb-1">Click to upload gallery photos</span>
                                        <input type="file" name="gallery[]" class="form-control-file d-block mx-auto" multiple accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Preview container -->
                        <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-2"></div>

                        <!-- Section 3: Pricing & Inventory -->
                        <div class="form-section-divider">
                            <h6><span class="figma-step-number">03</span> Pricing & Inventory Control</h6>
                            <p>Set price, discounts, part numbers, and stock warnings</p>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Regular Price ($) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light text-muted font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="0.00" value="{{ old('price') }}" required>
                                    </div>
                                    @if($errors->has('price'))
                                        <small class="text-danger font-weight-bold">{!! $errors->first('price') !!}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="discount_price">Discount Price ($)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light text-muted font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" name="discount_price" id="discount_price" placeholder="0.00" value="{{ old('discount_price') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="low_stock_qty_warning">Low Stock Alert Qty</label>
                                    <input type="number" class="form-control" name="low_stock_qty_warning" id="low_stock_qty_warning" placeholder="e.g. 5" value="{{ old('low_stock_qty_warning') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Stock Status</label>
                                    <select class="form-control select2" name="status" id="status">
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>In Stock (មានស្តុក)</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Out of Stock (អស់ស្តុក)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Classification & Vehicle Fitment -->
                        <div class="form-section-divider">
                            <h6><span class="figma-step-number">04</span> Vehicle Fitment & Categorization</h6>
                            <p>Specify make, model, year, engine, and product type</p>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Make (Brand) <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="category_id" name="category_id">
                                        <option value="">Choose make / brand...</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                        <option value="">Choose model...</option>
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
                                        <option value="">Choose engine...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_type_id">Product Type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_type_id">
                                        <option value="">Choose product type...</option>
                                        @foreach ($productType as $item)
                                            <option value="{{ $item->id }}" {{ old('product_type_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number">Part Number / SKU</label>
                                    <input type="text" class="form-control" name="number" id="number" placeholder="e.g. PN-99482-B" value="{{ old('number') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions Bar -->
                        <div class="d-flex align-items-center justify-content-end pt-4 mt-4 border-top" style="gap: 12px;">
                            <a href="{{url('admins/product')}}" class="btn btn-light rounded-pill px-4 font-weight-bold text-muted">Cancel</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary rounded-pill px-5 shadow-sm font-weight-bold" style="height: 44px;">
                                <i class="fal fa-check-circle mr-1"></i> Save Product
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
                            btn.prop('disabled', false).html('<i class="fal fa-check-circle mr-1"></i> Save Product');
                            if (typeof toastr !== 'undefined') {
                                toastr.success(res.message || 'Product created successfully!');
                            }
                            if (res.redirect) {
                                setTimeout(function() {
                                    window.location.href = res.redirect;
                                }, 800);
                            }
                        },
                        error: function(err) {
                            btn.prop('disabled', false).html('<i class="fal fa-check-circle mr-1"></i> Save Product');
                            var msg = 'Product creation failed. Please check form inputs.';
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
            }
        });
    </script>
@endsection
