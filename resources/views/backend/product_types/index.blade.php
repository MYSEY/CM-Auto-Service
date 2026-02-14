@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel card mb-g border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">

            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-th-list text-primary"></i>
                    </span>
                    Product Type <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/product-type/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fal fa-plus-circle mr-1"></i> Add New Type
                    </a>
                </div>
            </div>

            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="table-responsive">
                        <table id="dt-product-type" class="table m-0 table-hover w-100 dataTable dtr-inline" role="grid">
                            <thead class="bg-light">
                                <tr class="text-uppercase fs-nano text-muted">
                                    <th class="border-top-0 py-3 pl-4" style="width: 60px;">#</th>
                                    <th class="border-top-0 py-3 text-dark">Name</th>
                                    <th class="border-top-0 py-3">Description</th>
                                    <th class="border-top-0 py-3 text-center" style="width: 150px;">Status</th>
                                    <th class="border-top-0 py-3 text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) > 0)
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td class="align-middle pl-4 text-muted">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <span class="font-weight-bold text-dark d-block">{{ $item->name }}</span>
                                            </td>
                                            <td class="align-middle text-muted small">
                                                {{ $item->description ?? 'No description available' }}
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($item->is_active == 1)
                                                    <span class="badge badge-success badge-pill py-1 px-3 shadow-none" style="font-size: 11px;">
                                                        <i class="fal fa-check-circle mr-1"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary badge-pill py-1 px-3 shadow-none" style="font-size: 11px;">
                                                        <i class="fal fa-times-circle mr-1"></i> Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group">
                                                    <a href="{{url('admins/product-type',$item->id)}}/edit"
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
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-6">
                                            <div class="d-flex flex-column align-items-center justify-content-center py-5">
                                                <div class="mb-3">
                                                    <i class="fal fa-layer-group fa-5x text-muted opacity-25"></i>
                                                </div>
                                                <h4 class="text-muted fw-300">មិនទាន់មានទិន្នន័យប្រភេទផលិតផលនៅឡើយទេ</h4>
                                                <a href="{{url('admins/product-type/create')}}" class="btn btn-outline-primary rounded-pill px-4 mt-3">
                                                    <i class="fal fa-plus mr-1"></i> បន្ថែមប្រភេទផលិតផលដំបូង
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
    });
    const deleteData = (id)=>{
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: `@lang('lang.cancel')`,
            confirmButtonText: `@lang('lang.deleted')`,
        }).then(function(result)
        {
            if (result.value)
            {
                $.ajax({
                    type: "DELETE",
                    url: `{{url('/admins/product-type/${id}')}}`,
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
</script>
@endsection
