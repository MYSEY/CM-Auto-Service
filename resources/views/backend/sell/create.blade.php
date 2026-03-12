@extends('layouts.backend.admin')

@section('content')

<div class="row">
    <div class="col-xl-12">

        <div class="panel">

            <div class="panel-hdr">
                <h2>Sell Create</h2>
            </div>

            <div class="panel-container show">
                <div class="panel-content">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="customer_name"
                                       placeholder="Enter customer name">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text"
                                       class="form-control"
                                       id="telephone"
                                       placeholder="Enter telephone">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sell Date <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control"
                                       id="sell_date"
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <table class="table table-bordered" id="tbl_sell">
                                <thead>
                                    <tr>
                                        <th width="30%">Product</th>
                                        <th width="15%">Qty</th>
                                        <th width="20%">Price</th>
                                        <th width="20%">Sub Total</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control product_id select2">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->code }} - {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control quantity" min="0"></td>
                                        <td><input type="number" class="form-control price" min="0" step="0.01"></td>
                                        <td><input type="number" class="form-control sub_total" readonly></td>
                                        <td>
                                            <button type="button" class="btn btn-success btnAddRow">+</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                                        <td><input type="number" class="form-control grand_total" readonly></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <a href="{{ url('admins/sell') }}" class="btn btn-secondary">Cancel</a>
                        <button type="button" class="btn btn-success" id="btnSaveSell">Submit</button>
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
    $('.select2').select2();

    // Calculate sub_total and grand_total
    $(document).on('input', '.quantity, .price', function(){
        let row = $(this).closest('tr');
        let qty = parseFloat(row.find('.quantity').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        let subtotal = qty * price;
        row.find('.sub_total').val(subtotal.toFixed(2));
        calculateTotal();
    });

    // Add new product row
    $(document).on('click', '.btnAddRow', function(){
        let row = `
            <tr>
                <td>
                    <select class="form-control product_id select2">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->code }} - {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control quantity" min="0"></td>
                <td><input type="number" class="form-control price" min="0" step="0.01"></td>
                <td><input type="number" class="form-control sub_total" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btnRemoveRow">x</button>
                </td>
            </tr>
        `;
        $('#tbl_sell tbody').append(row);
        $('.select2').select2();
    });

    // Remove row
    $(document).on('click', '.btnRemoveRow', function(){
        $(this).closest('tr').remove();
        calculateTotal();
    });

    // Save sell
    $('#btnSaveSell').click(function(){
        let customer_name = $('#customer_name').val();
        let telephone = $('#telephone').val();
        let sell_date = $('#sell_date').val();
        let dataSell = [];

        if(!customer_name || !sell_date){
            toastr.error('Please fill customer name and sell date.');
            return;
        }

        $('#tbl_sell tbody tr').each(function(){
            let row = $(this);
            dataSell.push({
                product_id: row.find('.product_id').val(),
                quantity: row.find('.quantity').val(),
                price: row.find('.price').val(),
                sub_total: row.find('.sub_total').val()
            });
        });

        if(dataSell.length === 0){
            toastr.error('Please add at least one product.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{ url('admins/sell') }}",
            data: {
                customer_name: customer_name,
                telephone: telephone,
                sell_date: sell_date,
                grand_total: $('.grand_total').val(),
                dataSell: dataSell,
                _token: "{{ csrf_token() }}"
            },
            dataType: "JSON",
            success: function(res){
                if(res.status === 'success'){
                    toastr.success(res.message);
                    setTimeout(function(){
                        window.location.href = "{{ url('admins/sell') }}";
                    }, 1500);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr){
                toastr.error('Server Error: ' + xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

});

// Calculate grand total
function calculateTotal(){
    let total = 0;
    $('.sub_total').each(function(){
        total += parseFloat($(this).val()) || 0;
    });
    $('.grand_total').val(total.toFixed(2));
}
</script>
@endsection
