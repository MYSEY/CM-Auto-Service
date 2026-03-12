@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Order Edit
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
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
                                                    <option value="{{ $item->id }}"  {{ $data->product_id == $item->id ? 'selected' : '' }}>{{ $item->code }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control quantity" name="quantity[]" id="quantity[]" placeholder="Enter quantity" value="{{ $data->quantity }}"></td>
                                        <td><input type="number" class="form-control price" name="price[]" id="price[]" placeholder="Enter price" value="{{ $data->price }}"></td>
                                        <td><input type="number" class="form-control sub_total" name="sub_total[]" id="sub_total[]" placeholder="Enter Sub Total" readonly value="{{ $data->sub_total }}"></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success waves-effect waves-themed btnAddnewRecored" disabled><i class="fal fa-plus mr-1"></i> Add New Record</button>
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
                        <input type="text" id="order_id" value="{{ $data->id }}" hidden>
                        <a href="{{url('admins/order')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                        <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed" id="btnCreate">Submit</button>
                    </div>
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
                $('.required').each(function () {
                    if ($(this).val().trim() === '') {
                        $(this).css('border', '1px solid red');
                    } else {
                        $(this).css('border', '');
                    }
                });
                var customer_name = $("#customer_name").val();
                var telephone = $("#telephone").val();
                var email = $("#email").val();
                var order_date = $("#order_date").val();
                // var dataOrder = [];

                // $('#tbl_order tbody tr').each(function() {
                //     let row = $(this);

                //     dataOrder.push({
                //         product_id: row.find('.product_id').val(),
                //         quantity: row.find('.quantity').val(),
                //         price: row.find('.price').val(),
                //         sub_total: row.find('.sub_total').val()
                //     });
                // });
                $.ajax({
                    type: "PUT",
                    url: "{{ url('admins/order/update') }}",
                    data: {
                        order_id: $("#order_id").val(),
                        product_id: $('.product_id').val(),
                        quantity: $('.quantity').val(),
                        price: $('.price').val(),
                        sub_total: $('.sub_total').val(),
                        _token: "{{ csrf_token() }}"
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
                    },
                    error: function(xhr) {
                        toastr.error("Server Error: " + xhr.responseJSON?.message);
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
