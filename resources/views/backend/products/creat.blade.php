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
                            <label for="description">Description</label>
                            <textarea type="text" rows="10" class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Photo</label>
                            <span class="text-danger">*</span>
                            <input type="file" name="product_photo" class="form-control" id="image-input">
                            <p class="text-danger">{!! $errors->first('product_photo') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="title">Gallery</label><span class="text-danger">*</span>
                            <input type="file" name="gallery[]" class="form-control" required multiple accept="'gallery/*">
                            <p class="text-danger">{!! $errors->first('gallery') !!}</p>
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
                                    <span class="text-danger">*</span>
                                    <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Discrount price" value="{{ old('discount_price') }}">
                                    <p class="text-danger">{!! $errors->first('discount_price') !!}</p>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Category">Attribute</label>
                                    <select class="form-control" id="attributer_id" name="attributer_id">
                                        <option value="1">Red</option>
                                        <option value="2">Blue</option>
                                        <option value="3">Green</option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('attributer_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="value">Value (e.g. Red, Blue, Green)</label>
                                    <input type="text" class="form-control" name="value[]" id="value[]" placeholder="Enter value" multiple>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Category">Category</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose ctegories</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                <option value="1">New</option>
                                {{-- @foreach ($productStatus as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach --}}
                            </select>
                            <p class="text-danger">{!! $errors->first('status_id') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <span class="text-danger">*</span>
                            <textarea class="js-summernote form-control" id="saveToLocal" name="content">{{ old('content') }}</textarea>
                            <p class="text-danger">{!! $errors->first('content') !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="delivery_note">Delivery Note</label>
                            <textarea type="text" rows="10" class="form-control" name="delivery_note" id="delivery_note">{{ old('delivery_note') }}</textarea>
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
            // document.getElementById('gallery').addEventListener('change', function(e) {
            //     const preview = document.getElementById('gallery-preview');
            //     preview.innerHTML = ''; // clear previous
            //     const files = Array.from(e.target.files);

            //     if (!files.length) return;

            //     files.forEach(file => {
            //         // only preview images
            //         if (!file.type.startsWith('image/')) return;

            //         const reader = new FileReader();
            //         reader.onload = function(ev) {
            //             const img = document.createElement('img');
            //             img.src = ev.target.result;
            //             img.style.width = '120px';
            //             img.style.height = '120px';
            //             img.style.objectFit = 'cover';
            //             img.style.border = '1px solid #ddd';
            //             img.style.borderRadius = '6px';
            //             preview.appendChild(img);
            //         };
            //         reader.readAsDataURL(file);
            //     });
            // });
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
