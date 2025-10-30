@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Users Infor
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/users/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> @lang('lang.add_new')</a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info" style="width: 1163px;">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.profile')</th>
                                            <th>@lang('lang.user_id')</th>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.sex')</th>
                                            <th>@lang('lang.date_of_birth')</th>
                                            <th>@lang('lang.email')</th>
                                            <th>@lang('lang.restrict_branch')</th>
                                            <th>@lang('lang.access_branch')</th>
                                            <th>@lang('lang.role')</th>
                                            <th>@lang('lang.status')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $key=>$item)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    @if ($item->profile==null)
                                                        <img src="{{asset('admins/img/avatars/avatar-admin.png')}}" class="profile-image rounded-circle" style="object-fit: cover;" alt="profile">
                                                    @else
                                                        <img src="{{$item->profile}}" class="profile-image rounded-circle" style="object-fit: cover;" alt="profile">
                                                    @endif
                                                </td>
                                                <td>{{$item->cs_id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->sex == 1 ? "Male" : "Female"}}</td>
                                                <td>{{$item->UserDOB}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>
                                                    @if ($item->branches)
                                                        <ul>
                                                            @foreach ($item->branches as $value)
                                                                <span class="badge badge-primary badge-pill">
                                                                    <li>{{ Helper::getLang() == 'en' ? $value->name_en : $value->name_kh }}</li>
                                                                </span>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);">
                                                        <span class="btn btn-xs btn-info waves-effect waves-themed">{{ Helper::getLang() == 'en' ? $item->branch_name_default_en : $item->branch_name_default_kh}}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);">
                                                        <span class="btn btn-xs btn-success waves-effect waves-themed">{{$item->role_name}}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if (Auth::user()->RolePermission == 'Administrator')
                                                        <form method="POST" action="{{ route('users.updateStatus', $item->id) }}" style="display: inline-block;">
                                                            @csrf
                                                            @method('PUT')
                                                            <select class="form-control form-control-sm" name="is_active" onchange="this.form.submit()"
                                                                style="color: {{ $item->is_active == 0 ? 'red' : 'inherit' }};">
                                                                <option value="1" {{ $item->is_active == 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $item->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </form>
                                                    @else
                                                        @if ($item->is_active == 1)
                                                            <a href="javascript:void(0);">
                                                                <span class="btn btn-xs btn-success waves-effect waves-themed">Active</span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);">
                                                                <span class="btn btn-xs btn-success waves-effect waves-themed">Inactive</span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex demo">
                                                        @can('User Delete')
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>
                                                        @endcan
                                                        @can('User Edit')
                                                            <a href="{{url('admins/users',$item->id)}}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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

{{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}

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
                            Swal.fire("Deleted!", "Your file has been deleted.","success");
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
</script>
@endsection
