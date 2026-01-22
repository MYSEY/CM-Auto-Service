@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Engines List
                    </h2>
                    <div class="panel-toolbar">
                        <a href="{{url('admins/engine/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> Add New</a>
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
                                                    <th>Category</th>
                                                    <th>Sub Category Name</th>
                                                    <th>Engines Name</th>
                                                    <th>Part Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->Category?->name ?? '' }}</td>
                                                        <td>{{ $item->subCategory?->name ?? '' }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->part_number }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <a href="{{url('admins/engine',$item->id)}}/edit"
                                                                class="btn btn-icon btn-xs btn-outline-info waves-effect waves-themed mr-2"
                                                                data-toggle="tooltip" title="កែសម្រួល">
                                                                <i class="fal fa-pencil"></i>
                                                                </a>

                                                                <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-xs btn-outline-danger waves-effect waves-themed"
                                                                onclick="deleteData({{$item->id}})"
                                                                data-toggle="tooltip" title="លុបទិន្នន័យ">
                                                                <i class="fal fa-trash-alt"></i>
                                                                </a>
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
                    url: `{{ url('/admins/engine/${id}') }}`,
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
