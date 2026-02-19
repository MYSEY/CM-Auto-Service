@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-g border-0 shadow-sm bg-white p-3" style="border-radius: 12px;">
            <div class="row mb-2 align-items-center">
                <div class='col-md-4'>
                    <label class="form-label text-muted">Name</label>
                    <input type="text" name="name" value="" id="name" class='form-control shadow-none border-light-dark'>
                </div>
                <div class='col-md-4'>
                    <label class="form-label text-muted">Product Type</label>
                    <select class="select2 form-control w-100" name="product_type_id" id="product_type_id">
                        <option value="">-- Select --</option>
                        @foreach ($productTypes as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col-md-4'>
                    <label class="form-label text-muted">Category</label>
                    <select class="select2 form-control w-100" name="category_id" id="category_id">
                        <option value="">-- Select --</option>
                        @foreach ($dataCategory as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class='col-md-4'>
                    <label class="form-label text-muted">Sub Category</label>
                    <select class="select2 form-control w-100 sub_category" name="sub_category_id" id="sub_category_id">
                        <option value="">-- Select --</option>
                    </select>
                </div>
                <div class='col-md-4'>
                    <label class="form-label text-muted">Engine</label>
                    <select class="select2 form-control w-100 engine_id" name="engine_id" id="engine_id">
                        <option value="">-- Select --</option>
                    </select>
                </div>
                <div class='col-md-1'>
                    <label for=""></label>
                    <button type="submit" id="btnSearch" class="btn btn-primary btn-block mt-2 rounded-pill shadow-sm">
                        <i class="fal fa-search mr-1"></i> Search
                    </button>
                </div>
            </div>
        </div>

        <div id="panel-1" class="panel card mb-g border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">
            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-box text-primary"></i>
                    </span>
                    Products <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/product/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fal fa-plus-circle mr-1"></i> Add New Product
                    </a>
                </div>
            </div>

            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="table-responsive">
                        <table id="tbl_product" class="table m-0 table-hover w-100 dataTable dtr-inline" role="grid">
                            <thead class="bg-light">
                                <tr class="text-uppercase fs-nano text-muted">
                                    <th class="border-top-0 py-3 pl-4">#</th>
                                    <th class="border-top-0 py-3">Photo</th>
                                    <th class="border-top-0 py-3">Code</th>
                                    <th class="border-top-0 py-3 text-dark">Name</th>
                                    <th class="border-top-0 py-3">Type</th>
                                    <th class="border-top-0 py-3">Category</th>
                                    <th class="border-top-0 py-3">Sub</th>
                                    <th class="border-top-0 py-3">Engine</th>
                                    <th class="border-top-0 py-3">Part #</th>
                                    <th class="border-top-0 py-3">Price</th>
                                    <th class="border-top-0 py-3">Qty</th>
                                    <th class="border-top-0 py-3">Status</th>
                                    <th class="border-top-0 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
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
        $('#btnSearch').on('click', function() {
            $('#tbl_product').DataTable().ajax.reload();
        });
        dataTables();
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
    $('#tbl_product').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[0, 'desc']],
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
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
            // 1. # (ID)
            {
                data: 'id',
                name: 'id',
                className: 'align-middle pl-4 text-muted'
            },
            // 2. Photo
            {
                    data: 'product_photo',
                    name: 'product_photo',
                    className: 'align-middle',
                    render: function(data) {
                        const r2Url = "https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/";
                        if (data) {
                            return `<img src="${r2Url}${data}" width="50" height="40" style="object-fit:cover; border-radius:6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">`;
                        } else {
                            return `<span class="text-muted small">No Image</span>`;
                        }
                    }
                },
            // 3. Code
            {
                data: 'code',
                name: 'code',
                className: 'align-middle fw-500 text-primary'
            },
            // 4. Name (text-dark)
            {
                data: 'name',
                name: 'name',
                className: 'align-middle font-weight-bold text-dark'
            },
            // 5. Type
            {
                data: 'product_type_name',
                name: 'product_type_name',
                className: 'align-middle'
            },
            // 6. Category
            {
                data: 'category_name',
                name: 'category_name', // ត្រូវដូចឈ្មោះក្នុង Controller addColumn
                className: 'align-middle',
                render: function(data) {
                    let category = data ? data : 'None';
                    return `
                        <span class="badge badge-light border-0 py-1 px-2 text-primary" style="background: #eef2f7;">
                            <i class="fal fa-tag mr-1"></i> ${category}
                        </span>`;
                }
            },
            // 7. Sub (Sub Category)
            {
                data: 'sub_category_name',
                name: 'sub_category_name',
                className: 'align-middle text-muted'
            },
            // 8. Engine
            {
                data: 'engine_name',
                name: 'engine_name',
                className: 'align-middle'
            },
            // 9. Part # (Part Number)
            {
                data: 'number',
                name: 'number',
                className: 'align-middle',
                render: function(data) {
                    return `<span class="font-italic text-info border-bottom border-info small">${data || '-'}</span>`;
                }
            },
            // 10. Price
            {
                data: 'price',
                name: 'price',
                className: 'align-middle text-dark fw-500',
                render: function(data) {
                    return '$' + new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data || 0);
                }
            },
            // 11. Qty
            {
                data: 'low_stock_qty_warning',
                name: 'low_stock_qty_warning',
                className: 'align-middle text-center'
            },
            // 12. Status
            {
                data: 'status',
                name: 'status',
                className: 'align-middle',
                render: function(data, type, row) {
                    return `
                        <select class="form-control form-control-sm border-light changeStatus shadow-none" data-id="${row.id}" style="width: 115px; border-radius: 20px; font-size: 11px;">
                            <option value="0" ${data == 0 ? 'selected' : ''}>● Publish</option>
                            <option value="1" ${data == 1 ? 'selected' : ''}>● Pending</option>
                            <option value="2" ${data == 2 ? 'selected' : ''}>● Un-Publish</option>
                        </select>
                    `;
                }
            },
            // 13. Action
            {
                data: 'id',
                name: 'action',
                className: 'align-middle text-center',
                render: function(data, type, row) {
                    return `<div class="btn-group">
                            <a href="/admins/product/${row.id}/edit"
                            class="btn btn-icon btn-xs btn-outline-info rounded-circle mr-2 shadow-sm"
                            data-toggle="tooltip"
                            title="កែសម្រួល">
                                <i class="fal fa-pencil"></i>
                            </a>
                            <a href="javascript:void(0);"
                            class="btn btn-icon btn-xs btn-outline-danger rounded-circle shadow-sm"
                            onclick="deleteData(${row.id})"
                            data-toggle="tooltip"
                            title="លុបទិន្នន័យ">
                                <i class="fal fa-trash-alt"></i>
                            </a>
                        </div>`;
                }
            }
        ]
    });
}
</script>
@endsection
