@extends('layouts.backend.admin')

@section('content')
{{-- 💡 BREADCRUMBS --}}
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
    <li class="breadcrumb-item active">Product Categories</li>
    <li class="breadcrumb-item active">@lang('lang.index')</li>
</ol>

{{-- 💡 ALERT NOTIFICATIONS --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 8px;">
        <i class="fal fa-check-circle mr-2"></i> {!! session('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel card mb-g border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">

            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-tags text-primary"></i>
                    </span>
                    Product Categories <span class="fw-300 text-muted ml-1">List</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/category/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                        <i class="fal fa-plus-circle mr-1"></i> @lang('lang.add_new')
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
                                    <th class="border-top-0 py-3">Photo</th>
                                    <th class="border-top-0 py-3 text-dark">@lang('lang.name')</th>
                                    <th class="border-top-0 py-3">@lang('lang.description')</th>
                                    <th class="border-top-0 py-3">@lang('lang.slug')</th>
                                    <th class="border-top-0 py-3 text-center">Status</th>
                                    <th class="border-top-0 py-3 text-center">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                <tr>
                                    <td class="align-middle pl-4 text-muted">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        @if ($item->category_photo)
                                            <img src="{{ asset('images/category/' . $item->category_photo) }}"
                                                 style="object-fit: cover; width: 60px; height: 40px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                                 alt="category">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                <i class="fal fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle text-dark font-weight-bold">{{ $item->name }}</td>
                                    <td class="align-middle text-muted small">{{ Str::limit($item->description, 50) }}</td>
                                    <td class="align-middle"><code class="p-1 bg-light text-info rounded" style="font-size: 85%;">{{ $item->slug }}</code></td>
                                    <td class="align-middle text-center">
                                        @if ($item->is_active == 1)
                                            <span class="badge badge-success badge-pill py-1 px-3" style="font-size: 11px;">
                                                <i class="fal fa-check-circle mr-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-warning badge-pill py-1 px-3" style="font-size: 11px;">
                                                <i class="fal fa-exclamation-circle mr-1"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="{{url('admins/category',$item->id)}}/edit"
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
            title: "@lang('lang.are_you_sure')",
            text: "@lang('lang.are_you_sure_want_to_delete')",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: `@lang('lang.deleted')`,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: `{{ url('/admins/category/${id}') }}`,
                    success: function (data) {
                        if (data.mg === "success") {
                            toastr.success('@lang("lang.delete_success")', '@lang("lang.success")');
                            window.location.href = 'category';
                        } else {
                            toastr.error('@lang("lang.delete_error")', '@lang("lang.error")');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('@lang("lang.ajax_error")', 'Error');
                    }
                });
            }
        });
    }
</script>
@endsection
