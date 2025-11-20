@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Product Categories List
                    </h2>
                    <div class="panel-toolbar">
                        <a href="{{url('admins/sub-category/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> Add New</a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info">
                                            <thead class="">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Categroy Name</th>
                                                    <th>Sub Category Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->category->name }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ Str::limit($item->description, 50) }}</td>
                                                        <td>
                                                            @if ($item->is_active == 1)
                                                                <a href="javascript:void(0);">
                                                                    <span class="btn btn-xs btn-success waves-effect waves-themed">Active</span>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);">
                                                                    <span class="btn btn-xs btn-warning waves-effect waves-themed">Inactive</span>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex demo">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>
                                                                <a href="{{url('admins/sub-category',$item->id)}}/edit" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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

    const deleteData = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure want to delete",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: `Deleted`,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: `{{ url('/admins/sub-category/${id}') }}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.mg === "success") {
                            toastr.success('Delete Success', 'Success');
                            window.location.href = 'engine';
                        } else {
                            toastr.error('Delete Error', 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Ajax Error', 'Error');
                    }
                });
            }
        });
    }
</script>
@endsection
