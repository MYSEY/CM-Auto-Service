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
                    {{-- <form id="orderForm">
                        @csrf --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Enter customer name" value="{{ old('customer_name') }}">
                                    <p class="text-danger">{!! $errors->first('customer_name') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telephone">Telephone</label>
                                    <input type="number" class="form-control" name="telephone" id="telephone" placeholder="Enter telephone" value="{{ old('telephone') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="content">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Order Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" class="form-control" name="order_date" id="order_date" placeholder="Enter order date" value="{{ old('order_date') }}">
                                    <p class="text-danger">{!! $errors->first('order_date') !!}</p>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h3>Order Details</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tbl_order" class="table table-bordered">
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
                                                <select name="product_id[]" id="product_id[]" class="form-control select2 product_id">
                                                    <option value="">Please Select</option>
                                                    @foreach($products as $item)
                                                        <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control quantity" name="quantity[]" id="quantity[]" placeholder="Enter quantity"></td>
                                            <td><input type="number" class="form-control price" name="price" id="price[]" placeholder="Enter price"></td>
                                            <td><input type="number" class="form-control sub_total" name="sub_total" id="sub_total[]" placeholder="Enter Sub Total" readonly></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success waves-effect waves-themed btnAddnewRecored"><i class="fal fa-plus mr-1"></i> Add New Record</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                                            <td>
                                                <input type="number" class="form-control grand_total" name="grand_total" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/order')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                            <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed" id="btnCreate">Submit</button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function(){
            $(document).on('change', '.product_id', function () {
                let row = $(this).closest('tr');
                row.find('.quantity, .price, .sub_total').val('');
                calculateGrandTotal();
            });

            $(document).on('input', '.quantity, .price', function () {
                let row = $(this).closest('tr');

                let qty   = parseFloat(row.find('.quantity').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;

                row.find('.sub_total').val((qty * price).toFixed(2));

                calculateGrandTotal();
            });
            $(document).on('click', '.btnRemoveRow', function () {
                $(this).closest('tr').remove();
                calculateGrandTotal();
            });
            $("#btnCreate").on('click',function(){
                var customer_name = $("#customer_name").val();
                var telephone = $("#telephone").val();
                var email = $("#email").val();
                var order_date = $("#order_date").val();
                var orderDetail = [];

                $('#tbl_order tbody tr').each(function() {
                    let row = $(this);

                    orderDetail.push({
                        product_id: row.find('.product_id').val(),
                        quantity: row.find('.quantity').val(),
                        price: row.find('.price').val(),
                        sub_total: row.find('.sub_total').val()
                    });
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('admins/order') }}",
                    data: {
                        customer_name: customer_name,
                        telephone: telephone,
                        email: email,
                        order_date: order_date,
                        orderDetail : orderDetail,
                    },
                    dataType: "JSON",
                    success: function (res) {
                        if(res.status == 'success'){
                            toastr.success(res.message);
                            setTimeout(function(){
                                window.location.href = "{{ url('admins/order') }}";
                            }, 2000);
                        } else {
                            toastr.error(res.message);
                        }
                    }
                });
            });
            $(document).on('click', '.btnAddnewRecored', function () {
                let row = `
                <tr>
                    <td>
                        <select class="form-control select2 product_id" name="product_id[]">
                            <option value="">Please Select</option>
                            @foreach($products as $item)
                                <option value="{{ $item->id }}">{{ $item->code }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantity" name="quantity[]"></td>
                    <td><input type="number" class="form-control price" name="price[]"></td>
                    <td><input type="number" class="form-control sub_total" name="sub_total[]" readonly></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger btnRemoveRow">×</button>
                    </td>
                </tr>`;

                $('#tbl_order tbody').append(row);

                // Reinitialize select2
                $('.select2').select2();
            });
        });
        function calculateGrandTotal() {
            let total = 0;

            $('.sub_total').each(function () {
                total += parseFloat($(this).val()) || 0;
            });

            $('.grand_total').val(total.toFixed(2));
        }
    </script>
@endsection
