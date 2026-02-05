@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Order Create
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/order') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
                                    <p class="text-danger">{!! $errors->first('name') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telephone">telephone</label>
                                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Enter telephone" value="{{ old('telephone') }}">       
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content">email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tbl_product" class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Product</th>
                                            <th>product type</th>
                                            <th>category</th>
                                            <th>sub category</th>
                                            <th>engine</th>
                                            <th>quantity</th>
                                            <th>price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="product_id" id="product_id" class="form-control">
                                                    <option value="">Please Select</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="product_type" placeholder="Enter product type"></td>
                                            <td><input type="text" class="form-control" name="category" placeholder="Enter category"></td>
                                            <td><input type="text" class="form-control" name="sub_category" placeholder="Enter sub category"></td>
                                            <td><input type="text" class="form-control" name="engine" placeholder="Enter engine"></td>
                                            <td><input type="number" class="form-control" name="quantity" placeholder="Enter quantity"></td>
                                            <td><input type="number" class="form-control" name="price" placeholder="Enter price"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/order')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
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