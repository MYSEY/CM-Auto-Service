@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel mb-g">
            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-users text-primary"></i>
                    </span>
                    Users <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/users/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
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
                                    <th class="border-top-0 py-3">@lang('lang.profile')</th>
                                    <th class="border-top-0 py-3 text-dark">@lang('lang.name')</th>
                                    <th class="border-top-0 py-3">@lang('lang.user_name')</th>
                                    <th class="border-top-0 py-3">@lang('lang.sex')</th>
                                    <th class="border-top-0 py-3">@lang('lang.email')</th>
                                    <th class="border-top-0 py-3 text-center">@lang('lang.role')</th>
                                    <th class="border-top-0 py-3 text-center">@lang('lang.status')</th>
                                    <th class="border-top-0 py-3 text-center" style="width: 120px;">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td class="align-middle pl-4 text-muted">{{ $key + 1 }}</td>
                                        <td class="align-middle">
                                            @if ($item->profile == null)
                                                <img src="{{asset('backends/img/demo/avatars/avatar-admin.png')}}" class="profile-image rounded-circle" style="width: 36px; height: 36px; object-fit: cover; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" alt="profile">
                                            @else
                                                <img src="{{ asset('users/profiles/' . $item->profile) }}" class="profile-image rounded-circle" style="width: 36px; height: 36px; object-fit: cover; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" alt="profile">
                                            @endif
                                        </td>
                                        <td class="align-middle text-dark font-weight-bold">{{ $item->name }}</td>
                                        <td class="align-middle text-muted">{{ $item->user_name }}</td>
                                        <td class="align-middle">{{ $item->sex == 1 ? "Male" : "Female" }}</td>
                                        <td class="align-middle text-muted">{{ $item->email }}</td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-info badge-pill py-1 px-3" style="font-size: 11px;">
                                                Role: {{ $item->role_id }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($item->is_active == 1)
                                                <span class="badge badge-success badge-pill py-1 px-3" style="font-size: 11px;">
                                                    <i class="fal fa-check-circle mr-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-warning badge-pill py-1 px-3" style="font-size: 11px;">
                                                    <i class="fal fa-times-circle mr-1"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <a href="{{url('admins/users',$item->id)}}/edit"
                                                   class="btn btn-icon btn-xs btn-outline-info rounded-circle mr-2 shadow-sm"
                                                   data-toggle="tooltip" title="កែសម្រួល">
                                                    <i class="fal fa-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-icon btn-xs btn-outline-primary rounded-circle shadow-sm"
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

<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

@endsection
@section('script')
<script>
    $(function(){
        $('body').on('click','#onChangeRole a',function(){
            let role_id = $(this).attr('data-role-id');

            $.ajax({
                type: "POST",
                url: "{{url('admins/users/onchange')}}",
                data: {
                    role_id : role_id,
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.message == 'successfull') {
                        toastr.success("@lang('lang.data_has_been_save_success')", "@lang('lang.message_title')");
                        window.location.reload();
                    }
                }
            });
        });
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
                    url: `{{url('/admins/users/${id}')}}`,
                    success: function (data) {
                        if (data.mg == "success") {
                            toastr.success("Your file has been deleted.", "Deleted!");
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
