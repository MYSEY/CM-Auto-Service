@extends('layouts.backend.admin')
@section('content')
    <div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel card mb-g border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">

            {{-- 💡 PANEL HEADER: ស្ទីលដូចគ្នាជាមួយផ្នែកមុនៗ --}}
            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-sitemap text-primary"></i>
                    </span>
                    Sub Categories <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/sub-category/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fal fa-plus-circle mr-1"></i> Add New
                    </a>
                </div>
            </div>

            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="table-responsive">
                        <table id="dt-basic-example" class="table m-0 table-hover w-100 dataTable dtr-inline" role="grid">
                            <thead class="bg-light">
                                <tr class="text-uppercase fs-nano text-muted">
                                    <th class="border-top-0 py-3 pl-4" style="width: 50px;">#</th>
                                    <th class="border-top-0 py-3">Category Name</th>
                                    <th class="border-top-0 py-3 text-dark">Sub Category Name</th>
                                    <th class="border-top-0 py-3">Description</th>
                                    <th class="border-top-0 py-3 text-center" style="width: 120px;">Status</th>
                                    <th class="border-top-0 py-3 text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="align-middle pl-4 text-muted">{{ $item->id }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-light border-0 py-1 px-2 text-primary" style="background: #eef2f7;">
                                                <i class="fal fa-folder mr-1"></i> {{ $item->category->name ?? 'None' }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-dark font-weight-bold">{{ $item->name }}</span>
                                        </td>
                                        <td class="align-middle text-muted small">
                                            {{ Str::limit($item->description, 50) }}
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($item->is_active == 1)
                                                <span class="badge badge-success badge-pill py-1 px-3 shadow-none" style="font-size: 11px;">
                                                    <i class="fal fa-check-circle mr-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-warning badge-pill py-1 px-3 shadow-none" style="font-size: 11px;">
                                                    <i class="fal fa-exclamation-circle mr-1"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <a href="{{url('admins/sub-category',$item->id)}}/edit"
                                                   class="btn btn-icon btn-xs btn-outline-info rounded-circle mr-2 shadow-sm"
                                                   data-toggle="tooltip" title="កែសម្រួល">
                                                    <i class="fal fa-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-icon btn-xs btn-outline-danger rounded-circle shadow-sm"
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
