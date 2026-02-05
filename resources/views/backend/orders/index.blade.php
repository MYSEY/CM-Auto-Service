@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Orders
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/order/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> Add New</a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <!-- datatable start -->
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="tbl_product" class="table table-bordered table-hover table-striped w-100 table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info" style="width: 1163px;">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>telephone</th>
                                                <th>email</th>
                                                <th>Total QTY</th>
                                                <th>Total Price</th>
                                                <th>Total Discount</th>
                                                <th>Order Date</th>
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
        $('#btnSearch').on('click', function() {
            $('#tbl_product').DataTable().ajax.reload();
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
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'telephone',
                    name: 'telephone',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'total_qty',
                    name: 'total_qty',
                },
                {
                    data: 'total_price',
                    name: 'total_price',
                },
                {
                    data: 'total_discount',
                    name: 'total_discount',
                },
                {
                    data: 'order_date',
                    name: 'order_date',
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
                          <div class="d-flex align-items-center justify-content-center">
                            <a href="/admins/product/${row.id}/edit"
                            class="btn btn-icon btn-xs btn-outline-info waves-effect waves-themed mr-2"
                            title="កែសម្រួល">
                            <i class="fal fa-pencil"></i>
                            </a>

                            <a href="javascript:void(0);"
                            class="btn btn-icon btn-xs btn-outline-danger waves-effect waves-themed"
                            onclick="deleteData(${row.id})"
                            title="លុបទិន្នន័យ">
                            <i class="fal fa-trash-alt"></i>
                            </a>
                        </div>`;
                    },
                },
            ],
            order: [[0, 'desc']]
        });
    }
</script>
@endsection