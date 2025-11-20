@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class='row mb-2 align-items-center'>
            <div class='col-md-4'>
                <label for="">Name</label>
                <input type="text" name="name" value="" id="name" class='form-control'>
            </div>
            <div class='col-md-4'>
                <label for="">Product Type</label>
                <select class="select2 form-control w-100 select2-hidden-accessible" name="product_type_id" id="product_type_id">
                    <option value="">-- Select --</option>
                    @foreach ($productTypes as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-md-4'>
                <label for="">Category</label>
                <select class="select2 form-control w-100 select2-hidden-accessible" name="category_id" id="category_id">
                    <option value="">-- Select --</option>
                    @foreach ($dataCategory as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class='col-md-4'>
                <label for="">Sub Category</label>
                <select class="select2 form-control w-100 select2-hidden-accessible" name="category_id" id="category_id">
                    <option value="">-- Select --</option>
                </select>
            </div>
            <div class='col-md-4'>
                <label for="">Engine</label>
                <select class="select2 form-control w-100 select2-hidden-accessible" name="engin_id" id="engin_id">
                    <option value="">-- Select --</option>
                </select>
            </div>
            <div class='col-md-1'>
                <label for=""></label>
                <button type="submit" id="btnSearch" class="btn btn-info">Search</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Products
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/product/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> Add New</a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <!-- datatable start -->
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info" style="width: 1163px;">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>ProductPhoto</th>
                                                <th>Name</th>
                                                <th>ProductType</th>
                                                <th>Category</th>
                                                <th>SubCategory</th>
                                                <th>Engine</th>
                                                <th>SerialNumber</th>
                                                <th>Price</th>
                                                <th>DiscountPrice</th>
                                                <th>Year</th>
                                                <th>Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($data as $key=>$item)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                        @if ($item->product_photo)
                                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" style="object-fit: cover;width: 100px;height: 50px;" alt="product">
                                                        @endif
                                                    </td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->productType ? $item->productType->name : ''}}</td>
                                                    <td>{{ $item->category ? $item->category->name : '' }}</td>
                                                    <td>{{ $item->subCategory ? $item->subCategory->name : '' }}</td>
                                                    <td>{{ $item->proEngine ? $item->proEngine->name:''}}</td>
                                                    <td>{{ $item->subCategory ? $item->subCategory->serial_number : '' }}</td>
                                                    <td>{{$item->PriceFormat}}</td>
                                                    <td>{{$item->year}}</td>
                                                    <td>{{$item->number}}</td>
                                                    <td>{{$item->DiscountPriceFormat}}</td>
                                                    <td>
                                                        <select class="form-control" id="btnStatus">
                                                            <option value="1" {{ $item->publish==1 ? 'selected' : '' }}>Publish</option>
                                                            <option value="0" {{ $item->publish==0 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $item->publish==2 ? 'selected' : '' }}>Un-Publish</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex demo">
                                                            <input type="text" value="{{ $item->id }}" id="id" hidden>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>
                                                            <a href="{{url('admins/product',$item->id)}}/edit" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
@endsection
@section('script')
<script>
    $(function(){
        $("#btnStatus").on('change',function(){
            var publish = $(this).val();
            var id = $("#id").val();
            $.ajax({
                type: "POST",
                url: "{{ url('admins/product/change/publish') }}/" + id,
                data: {
                    publish:publish,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.msg === 'success') {
                        toastr.success('Publish product successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error('Failed to update status.');
                    }
                },
                error: function (xhr) {
                    toastr.error('Something went wrong.');
                    console.error(xhr.responseText);
                }
            });
        });
        $('#btnSearch').on('click', function() {
            // Get values from the input fields
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();
            let user = $('select[name="user"]').val();
            let block = $('select[name="block"]').val();
            let sector = $('select[name="sector"]').val();
            let street = $('select[name="street"]').val();
            let side_of_street = $('select[name="side_of_street"]').val();
            let business_type_id = $('select[name="business_type_id"]').val();
            let category_id = $('select[name="category_id"]').val();
            let sub_category_id = $('select[name="sub_category_id"]').val();
            // Reload DataTable with the filter values
            $('#tbl_customer').DataTable().ajax.reload();
        });
        dataTables();
    });
    const deleteData = (id)=>{
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: `Cancel`,
            confirmButtonText: `Deleted`,
        }).then(function(result)
        {
            if (result.value)
            {
                $.ajax({
                    type: "DELETE",
                    url: `{{url('/admins/product/${id}')}}`,
                    success: function (data) {
                        if (data.mg == "success") {
                            toastr.success("Your file has been deleted.", "Deleted!");
                            // ✅ Delay reload by 2 seconds
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong.", "Error");
                    }
                });
            }
        });
    }
    function dataTables() {
        $('#dt-basic-example').DataTable({
            // dom: 'Blfrtip',
            pageLength: 10,
            destroy: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [ [10, 25, 50,100,-1], [10, 25, 50,100, "All"] ],
            ajax: {
                url: '{{ URL("admins/product") }}',
                type: 'GET',
                // data: function(d) {
                //     d.invoice_no = invoice_no;
                //     d.customer_no = customer_no;
                //     d.customer_name = customer_name;
                //     d.collector_id = collector_id;
                //     d.status = status;
                //     d.block = block;
                //     d.sector = sector;
                //     d.street_no = street_no;
                //     d.side_of_street = side_of_street;
                //     d.filter_month = filter_month;
                // }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'product_photo',
                    name: 'product_photo',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        return `<img src="/images/products/${data}" width="60" height="45" style="object-fit:cover;border-radius:4px;">`;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    visible: false,
                    searchable: true
                },
                {
                    data: 'product_type_name',
                    name: 'product_type_name',
                },
                {
                    data: 'category_name',
                    name: 'category_name',
                },
                {
                    data: 'sub_category_name',
                    name: 'sub_category_name',
                },
                {
                    data: 'engine_name',
                    name: 'engine_name',
                },
                {
                    data: 'serial_number',
                    name: 'serial_number',
                    searchable: true
                },
                {
                    data: 'price',
                    name: 'price',
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(data || 0);
                    }
                },
                {
                    data: 'discount_price',
                    name: 'discount_price',
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(data || 0);
                    }
                },
                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'number',
                    name: 'number',
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        return `
                            <select class="form-control changeStatus" data-id="${row.id}">
                                <option value="1" ${row.status == 1 ? 'selected' : ''}>Publish</option>
                                <option value="0" ${row.status == 0 ? 'selected' : ''}>Pending</option>
                                <option value="2" ${row.status == 2 ? 'selected' : ''}>Un-Publish</option>
                            </select>
                        `;
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex demo">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1"
                                onclick="deleteData(${row.id})" title="Delete Record">
                                <i class="fal fa-times"></i>
                                </a>
                                <a href="/admins/product/${row.id}/edit"
                                class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit">
                                <i class="fal fa-edit"></i>
                                </a>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                },
            ],
            order: [[0, 'desc']]
        });
    }
</script>
@endsection
