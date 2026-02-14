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
                                    <label for="name">Customer Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
                                    <p class="text-danger">{!! $errors->first('name') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Enter telephone" value="{{ old('telephone') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h3>Order Details</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tbl_product" class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>SubTotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="product_code" id="product_code" class="form-control select2">
                                                    <option value="">Please Select</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->code }}">{{ $product->code }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control quantity" name="quantity" placeholder="Enter quantity"></td>
                                            <td><input type="number" class="form-control price" name="price" placeholder="Enter price"></td>
                                            <td><input type="number" class="form-control sub_total" name="sub_total" placeholder="Enter Sub Total"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success waves-effect waves-themed"><i class="fal fa-plus mr-1"></i> Add New Record</button>
                                            </td>
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
            $(document).on('change', '#product_code', function () {
                $('.price').val('');
                $('.quantity').val('');
                $('.sub_total').val('');
            });

            $(document).on('keyup', '.quantity, .price', function () {
                let quantity = parseFloat($('.quantity').val()) || 0;
                let price    = parseFloat($('.price').val()) || 0;
                let totalprice = quantity * price;
                $('.sub_total').val(totalprice.toFixed(2));
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
