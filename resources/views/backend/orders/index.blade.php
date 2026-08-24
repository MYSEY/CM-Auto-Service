@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <i class="fal fa-shopping-bag mr-2 text-primary"></i> Orders <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/order/create')}}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm font-weight-bold">
                        <i class="fal fa-plus-circle mr-1"></i> Add New Order
                    </a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <!-- datatable start -->
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="tbl_product" class="table table-hover w-100 dataTable dtr-inline" role="grid">
                                        <thead>
                                            <tr class="text-uppercase fs-nano text-muted">
                                                <th class="border-top-0 py-3 pl-4">#</th>
                                                <th class="border-top-0 py-3">Product Name</th>
                                                <th class="border-top-0 py-3">Product Type</th>
                                                <th class="border-top-0 py-3">Category</th>
                                                <th class="border-top-0 py-3">Sub Category</th>
                                                <th class="border-top-0 py-3">Engine</th>
                                                <th class="border-top-0 py-3">Part #</th>
                                                <th class="border-top-0 py-3">Qty</th>
                                                <th class="border-top-0 py-3">Price</th>
                                                <th class="border-top-0 py-3">Sub Total</th>
                                                <th class="border-top-0 py-3">Order Date</th>
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
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
@endsection
@section('script')
<script>
    $(function(){
        $('#btnSearch').on('click', function() {
            $('#tbl_product').DataTable().ajax.reload();
        });
        $(document).on('change', '.changeStatus', function () {
            let status = $(this).val();
            let id = $(this).data('id');
            if (status !='requesting') {
                $.confirm({
                    title: 'Accepted',
                    content: 'Are you sure want to accepted this order?',
                    type: "blue",
                    buttons: {
                        submit: {
                            text: 'Submit',
                            btnClass: 'btn-green',
                            action: function () {
                                axios.post('{{ URL("admins/order/change-status") }}', {
                                    id: id,
                                    status: status
                                }).then(function (response) {
                                    if (response.data.success) {
                                        new Noty({
                                            text: 'The process has been successfully',
                                            type: "success",
                                            timeout: 2500
                                        }).show();
                                        window.location.replace("{{ URL('admins/order') }}");
                                        return;
                                    } else {
                                        new Noty({
                                            text: 'Something went wrong please try again later',
                                            type: "error",
                                            timeout: 3000
                                        }).show();
                                    }
                                }).catch(function (error) {
                                    new Noty({
                                        text: 'Something went wrong please try again later',
                                        type: "error",
                                        timeout: 3000
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm'
                        }
                    }
                });
            }
        });
        $(document).on('click','.deleteData', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('admins/order') }}/" + id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status=='success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                });
                                $('#tbl_product').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message,
                                });
                            }
                        }
                    });
                }
            });
        });
        dataTables();
    });

    function dataTables() {
        $('#tbl_product').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            destroy: true,
            order: [[0, 'desc']],
            lengthMenu: [ [10, 25, 50,100,-1], [10, 25, 50,100, "All"] ],
            ajax: {
                url: '{{ URL("admins/order") }}',
                type: 'GET',
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'product_name',
                    name: 'product_name',
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
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                },
                {
                    data: 'price',
                    name: 'price',
                },
                {
                    data: 'sub_total',
                    name: 'sub_total',
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if(row.status == 'requesting') {
                            return `
                                <select class="form-control changeStatus" data-id="${row.id}">
                                    <option value="requesting" ${row.status == 'requesting' ? 'selected' : ''}>Requesting</option>
                                    <option value="approve" ${row.status == 'approve' ? 'selected' : ''}>Approve</option>
                                </select>
                            `;
                        } else if(row.status == 'approve') {
                            return `<span class="badge badge-success">Approved</span>`;
                        }
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    render: function(data, type, row) {
                        if (row.status=='approve') {
                            return ``;
                        }else{
                            return `
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ url('/admins/order') }}/${row.id}/edit" class="btn btn-icon btn-xs btn-outline-info waves-effect waves-themed mr-2" title="កែសម្រួល"> <i class="fal fa-pencil"></i></a>
                                <a href="javascript:void(0);" class="btn btn-icon btn-xs btn-outline-primary waves-effect waves-themed deleteData" data-id="${row.id}" title="លុបទិន្នន័យ"><i class="fal fa-trash-alt"></i></a>
                            </div>`;
                        }
                    },
                },
            ],
            order: [[0, 'desc']]
        });
    }
</script>
@endsection
