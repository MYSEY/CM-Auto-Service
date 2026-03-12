@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-hdr d-flex justify-content-between align-items-center">
                <h2>Sell List</h2>
                <div class="panel-toolbar">
                    <a href="{{ url('admins/sell/create') }}" class="btn btn-sm btn-success waves-effect waves-themed">
                        <i class="fal fa-plus mr-1"></i> Add New
                    </a>
                </div>
            </div>

            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <table id="tbl_product" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Sell Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
$(function() {

    // Initialize DataTable
    dataTables();

    // Change status
    $(document).on('change', '.changeStatus', function() {
        let status = $(this).val();
        let id = $(this).data('id');

        if (status != 'requesting') {
            $.confirm({
                title: 'Confirm Status Change',
                content: 'Are you sure you want to update this sell status?',
                type: 'blue',
                buttons: {
                    submit: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        action: function() {
                            axios.post('{{ url("admins/sell/change-status") }}', {
                                id: id,
                                status: status
                            })
                            .then(function(response){
                                if(response.data.success){
                                    new Noty({
                                        text:'Status updated successfully!',
                                        type:"success",
                                        timeout:2500
                                    }).show();
                                    $('#tbl_product').DataTable().ajax.reload();
                                } else {
                                    new Noty({
                                        text:'Something went wrong!',
                                        type:"error",
                                        timeout:3000
                                    }).show();
                                }
                            })
                            .catch(function(){
                                new Noty({
                                    text:'Server error!',
                                    type:"error",
                                    timeout:3000
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text:'Cancel',
                        btnClass:'btn-secondary btn-sm'
                    }
                }
            });
        }
    });

    // Delete sell
    $(document).on('click', '.deleteData', function() {
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
                axios.delete(`{{ url('admins/sell') }}/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(function(response) {
                    if(response.data.status == 'success') {
                        Swal.fire('Deleted!', response.data.message, 'success');
                        $('#tbl_product').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', response.data.message, 'error');
                    }
                })
                .catch(function(error) {
                    Swal.fire('Server Error', error.response?.data?.message || 'Cannot delete the record.', 'error');
                });
            }
        });
    });

});

// DataTables function
function dataTables() {
    $('#tbl_product').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[0,'desc']],
        lengthMenu: [[10,25,50,100,-1],[10,25,50,100,"All"]],
        ajax:{
            url:'{{ url("admins/sell") }}',
            type:'GET'
        },
        columns:[
            {data:'id', name:'id'},
            {data:'invoice_no', name:'invoice_no'},
            {data:'customer_name', name:'customer_name'},
            {data:'total_amount', name:'total_amount'},
            {data:'grand_total', name:'grand_total'},
            {data:'paid_amount', name:'paid_amount'},
            {data:'due_amount', name:'due_amount'},
            {data:'sell_date', name:'sell_date'},
            {
                data:'status',
                name:'status',
                render:function(data,type,row){
                    if(row.status=='unpaid') {
                        return `<span class="badge badge-warning">Unpaid</span>`;
                    } else if(row.status=='paid') {
                        return `<span class="badge badge-success">Paid</span>`;
                    } else {
                        return `<span class="badge badge-info">${row.status}</span>`;
                    }
                }
            },
            {
                data:'id',
                name:'action',
                render:function(data,type,row){
                    return `
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="{{ url('/admins/sell') }}/${row.id}/edit" class="btn btn-icon btn-xs btn-outline-info mr-2">
                            <i class="fal fa-pencil"></i>
                        </a>
                       <a href="javascript:void(0);" class="btn btn-icon btn-xs btn-outline-danger deleteData" data-id="${row.id}">
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
