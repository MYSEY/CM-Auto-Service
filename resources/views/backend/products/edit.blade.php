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
                            <label for="description">Description</label>
                            <textarea type="text" rows="10" class="form-control" name="description" id="description">{{ $data->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Photo</label>
                            <span class="text-danger">*</span>
                            <input type="file" name="product_photo" class="form-control" id="image-input">
                            <p class="text-danger">{!! $errors->first('product_photo') !!}</p>
                            <div id="gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;">
                                <img src="{{ asset('images/products/' . $data->product_photo) }}" style="object-fit: cover;width: 100px;height: 50px;" alt="product">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Gallery</label><span class="text-danger">*</span>
                            <input type="file" name="gallery[]" class="form-control" required multiple accept="'gallery/*">
                            <p class="text-danger">{!! $errors->first('gallery') !!}</p>
                            <div id="gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;">
                                @foreach ($data->productImage as $item)
                                    <img
                                        src="{{ asset('images/products/gallery/' . $item->path_name) }}"
                                        style="object-fit: cover; width: 100px; height: 50px; border-radius: 5px;"
                                        alt="product image"
                                    >
                                @endforeach
                            </div>
                        </div>
                        <!-- preview container -->
                        <div id="gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Price">Price</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" value="{{ $data->price }}">
                                    <p class="text-danger">{!! $errors->first('price') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Discrount Price">Discount Price</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Discrount price" value="{{ $data->discount_price }}">
                                    <p class="text-danger">{!! $errors->first('discount_price') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Category">Category</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose ctegories</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $data->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="Category">Sub Category</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control sub_category" id="sub_category_id" name="sub_category_id">
                                        <option value="">Please choose sub ctegories</option>
                                        @foreach($sub_category as $item)
                                            <option value="{{ $item->id }}" {{ $data->sub_category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('sub_category_id') !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Category">Product Status</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" name="status_id">
                                <option value="">Please Choose Product Status</option>
                                @foreach ($productStatus as $item)
                                    <option value="{{ $item->id }}" {{ $data->status_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{!! $errors->first('status_id') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <span class="text-danger">*</span>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="content">{{ old('content', $data->content) }}</textarea>
                            <p class="text-danger">{!! $errors->first('content') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="delivery_note">Delivery Note</label>
                            <textarea type="text" rows="10" class="form-control" name="delivery_note" id="delivery_note">{{ $data->delivery_note }}</textarea>
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
        });
    </script>
@endsection
