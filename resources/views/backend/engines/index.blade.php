@extends('layouts.backend.admin')
@section('content')
    <div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel card mb-g border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">

            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-engine text-primary"></i>
                    </span>
                    Engines <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/engine/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fal fa-plus-circle mr-1"></i> Add New Engine
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
                                    <th class="border-top-0 py-3">Category</th>
                                    <th class="border-top-0 py-3">Sub Category</th>
                                    <th class="border-top-0 py-3 text-dark">Engines Name</th>
                                    <th class="border-top-0 py-3">Part Number</th>
                                    <th class="border-top-0 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) > 0)
                                    @foreach ($data as $key=>$item)
                                        <tr>
                                            <td class="align-middle pl-4 text-muted">{{ $item->id }}</td>
                                            <td class="align-middle">
                                                <span class="badge badge-light border-0 py-1 px-2 text-primary" style="background: #eef2f7;">
                                                    <i class="fal fa-tag mr-1"></i> {{ $item->Category?->name ?? 'None' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-muted">{{ $item->subCategory?->name ?? '-' }}</td>
                                            <td class="align-middle">
                                                <span class="text-dark font-weight-bold">{{ $item->name }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="font-italic text-info border-bottom border-info">{{ $item->part_number }}</span>
                                            </td>
                                          <td class="align-middle text-center">
                                            <div class="btn-group">
                                                {{-- ប៊ូតុងកែសម្រួល - ប្រើ outline-info និង fa-pencil --}}
                                                <a href="{{url('admins/engine', $item->id)}}/edit"
                                                class="btn btn-icon btn-xs btn-outline-info rounded-circle mr-2 shadow-sm"
                                                data-toggle="tooltip"
                                                title="កែសម្រួល">
                                                    <i class="fal fa-pencil"></i>
                                                </a>

                                                {{-- ប៊ូតុងលុប - ប្រើ outline-danger --}}
                                                <a href="javascript:void(0);"
                                                class="btn btn-icon btn-xs btn-outline-danger rounded-circle shadow-sm"
                                                onclick="deleteData({{$item->id}})"
                                                data-toggle="tooltip"
                                                title="លុបទិន្នន័យ">
                                                    <i class="fal fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-6">
                                            <div class="d-flex flex-column align-items-center justify-content-center py-5">
                                                <div class="mb-3">
                                                    <i class="fal fa-box-open fa-5x text-muted opacity-25"></i>
                                                </div>
                                                <h4 class="text-muted fw-300">មិនទាន់មានទិន្នន័យនៅក្នុងបញ្ជីនៅឡើយទេ</h4>
                                                <p class="text-muted mb-4">សូមចុចប៊ូតុងខាងក្រោមដើម្បីបន្ថែមទិន្នន័យថ្មី</p>
                                                <a href="{{url('admins/engine/create')}}" class="btn btn-outline-primary rounded-pill px-4">
                                                    <i class="fal fa-plus mr-1"></i> ចាប់ផ្តើមបន្ថែមឥឡូវនេះ
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
