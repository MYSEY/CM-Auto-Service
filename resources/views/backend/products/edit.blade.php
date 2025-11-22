@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Product
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/product',$data->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ $data->name }}">
                            <p class="text-danger">{!! $errors->first('name') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="Description">Description</label>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="description">{{ old('description', $data->description) }}</textarea>
                        </div>

                        <div id="alert-message" class="alert" style="display:none; margin-bottom: 15px;"></div>

                        <div class="form-group">
                            <label for="title">Photo</label>
                            <span class="text-danger">*</span>
                            <input type="file" name="product_photo" class="form-control" id="image-input">
                            <p class="text-danger">{!! $errors->first('product_photo') !!}</p>
                            <div id="photo-preview" style="margin-top:10px;">
                                @if ($data->product_photo)
                                    <div id="main-photo-container" style="display:flex; align-items:center; gap: 8px;">
                                        <img id="main-product-photo" src="{{ asset('images/products/' . $data->product_photo) }}"
                                            style="object-fit: cover; width: 100px; height: 50px;" alt="product photo">
                                        {{-- AJAX REMOVE MAIN PHOTO LINK --}}
                                        <a href="#" class="text-danger delete-photo"
                                            data-id="{{ $data->id }}"
                                            data-url="{{ route('product.delete_photo', $data->id) }}">
                                            Remove Photo
                                        </a>
                                    </div>
                                @else
                                    <p id="main-photo-placeholder">No main photo currently set.</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Gallery</label>
                            <input type="file" name="gallery[]" class="form-control" required multiple accept="image/*">
                            <div id="gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;">
                                @forelse ($data->productImage as $item)
                                    {{-- Wrap each image in an ID for easy removal --}}
                                    <div id="gallery-image-{{ $item->id }}" style="position: relative; width: 100px; height: 50px;">
                                        <img
                                            src="{{ asset('images/products/gallery/' . $item->path_name) }}"
                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;"
                                            alt="product image"
                                        >
                                        {{-- AJAX DELETE GALLERY IMAGE BUTTON --}}
                                        <a href="#"
                                        class="delete-gallery-image"
                                        data-id="{{ $item->id }}"
                                        data-url="{{ route('product.delete_gallery_image', $item->id) }}"
                                        style="position: absolute; top: 0; right: 0; background: rgba(255, 0, 0, 0.7); color: white; border-radius: 0 5px 0 0; padding: 2px 5px; line-height: 1; text-decoration: none; font-weight: bold; cursor: pointer;">
                                            X
                                        </a>
                                    </div>
                                @empty
                                    <p id="gallery-placeholder">No gallery images currently set.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Price">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" value="{{ $data->price }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Discount Price">Discount Price</label>
                                    <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Discount price" value="{{ $data->discount_price }}">
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Product Year">Year</label>
                                    <select class="form-control" name="year" id="year">
                                        <option value="">-- Select --</option>
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Number">Number</label>
                                    <input type="text" class="form-control" name="number" id="number" placeholder="Enter Number" value="{{ $data->number }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Category">Make</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose make</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $data->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Model">Model</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control sub_category" id="sub_category_id" name="sub_category_id">
                                        <option value="">Please choose model</option>
                                        @foreach($sub_category as $item)
                                            <option value="{{ $item->id }}" {{ $data->sub_category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('sub_category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Engine">Engine</label>
                                    <select class="form-control engine_id" id="engine_id" name="engine_id">
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

                        <div class="form-group">
                            <label for="Category">Product Type</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" name="product_type_id">
                                <option value="">Please choose product type</option>
                                @foreach ($producttype as $item)
                                    <option value="{{ $item->id }}" {{ $data->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{!! $errors->first('product_type_id') !!}</p>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <input type="text" id="id" name="id" value="{{ $data->id }}" hidden>
                            <a href="{{url('admins/product')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                            <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">Submit</button>
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
                alertBox.removeClass('alert-success alert-danger').addClass(`alert-${type}`).text(message).fadeIn();
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
        });
    </script>
@endsection
