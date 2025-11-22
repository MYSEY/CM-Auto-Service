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
                <select class="select2 form-control w-100 select2-hidden-accessible sub_category" name="sub_category_id" id="sub_category_id">
                    <option value="">-- Select --</option>
                </select>
            </div>
            <div class='col-md-4'>
                <label for="">Engine</label>
                <select class="select2 form-control w-100 select2-hidden-accessible engine_id" name="engine_id" id="engine_id">
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
                                                <th>Patr Nnumber</th>
                                                <th>Price</th>
                                                <th>DiscountPrice</th>
                                                <th>Year</th>
                                                <th>Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
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
        $('#btnSearch').on('click', function() {
            $('#dt-basic-example').DataTable().ajax.reload();
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
            pageLength: 10,
            processing: true,
            serverSide: true,
            destroy: true,
            order: [[0, 'desc']],
            lengthMenu: [ [10, 25, 50,100,-1], [10, 25, 50,100, "All"] ],
            ajax: {
                url: '{{ URL("admins/product") }}',
                type: 'GET',
                data: function(d) {
                    d.name = $('input[name="name"]').val();
                    d.product_type_id = $('select[name="product_type_id"]').val();
                    d.category_id = $('select[name="category_id"]').val();
                    d.sub_category_id = $('select[name="sub_category_id"]').val();
                    d.engine_id = $('select[name="engine_id"]').val();
                }
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
                    render: function (data, type, row) {
                        if (data) {
                            return `<img src="/images/products/${data}" width="60" height="45" style="object-fit:cover;border-radius:4px;">`;
                        } else {
                            return `No Image`;
                        }
                    }
                },
                {
                    data: 'name',
                    name: 'name',
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
                    data: 'part_number',
                    name: 'part_number',
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
