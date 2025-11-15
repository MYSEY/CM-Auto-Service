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
                    <form method="POST" action="{{ url('admins/product') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
                            <p class="text-danger">{!! $errors->first('name') !!}</p>
                        </div>
                         <div class="form-group">
                            <label for="content">description</label>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Photo</label>
                            <input type="file" name="product_photo" class="form-control" id="image-input">
                        </div>
                        <div class="form-group">
                            <label for="title">Gallery</label>
                            <input type="file" name="gallery[]" class="form-control" required multiple accept="'gallery/*">
                        </div>
                        <!-- preview container -->
                        <div id="gallery-preview" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Price">Price</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" value="{{ old('price') }}">
                                    <p class="text-danger">{!! $errors->first('price') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Discrount Price">Discount Price</label>
                                    <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Discrount price" value="{{ old('discount_price') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Make">Make</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose make</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    </select>
                                    <p class="text-danger">{!! $errors->first('sub_category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Engine">Engine</label>
                                    <select class="form-control engine_id" id="engine_id" name="engine_id">
                                        <option value="">Please choose engine</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Category">Product Type</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" name="product_type_id">
                                <option value="">Please Choose product type</option>
                                @foreach ($productType as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{!! $errors->first('product_type_id') !!}</p>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
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
