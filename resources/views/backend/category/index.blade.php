@extends('layouts.backend.admin')

@section('content')
    {{-- 💡 BREADCRUMBS: កែសម្រួល URL និង Text --}}
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">Product Categories</li> {{-- កែពី @lang('lang.company_info') --}}
        <li class="breadcrumb-item active">@lang('lang.index')</li> {{-- ផ្លាស់ប្តូរពី @lang('lang.create') --}}
    </ol>

   {{-- 💡 ពិនិត្យមើលសារជូនដំណឹង (Success/Error) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Product Categories List
                    </h2>
                    <div class="panel-toolbar">
                        {{-- 💡 ADD NEW Button: ប្រើ route helper --}}
                        <a href="{{url('admins/category/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> @lang('lang.add_new')</a>
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
                                                    <th>Catagory Photo</th>
                                                    <th>@lang('lang.name')</th>
                                                    <th>@lang('lang.description')</th>
                                                    <th>@lang('lang.slug')</th>
                                                    <th>Status</th> {{-- កែពី @lang('lang.is_active') --}}
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$item)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                        @if ($item->category_photo)
                                                            <img src="{{ asset('images/category/' . $item->category_photo) }}" style="object-fit: cover;width: 100px;height: 50px;" alt="category">
                                                        @endif
                                                         {{-- ✅ KHMER: គណនា Index ឲ្យត្រឹមត្រូវតាមទំព័រ (សម្រាប់ paginate) --}}
                                                        <td>{{$item->name}}</td>
                                                        <td>{{ Str::limit($item->description, 50) }}</td> {{-- កំណត់ត្រឹម 50 តួអក្សរ --}}
                                                        <td>{{$item->slug}}</td>

                                                        {{-- 💡 STATUS DISPLAY --}}
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

                                                        {{-- 💡 ACTION BUTTONS --}}
                                                        <td>

                                                              <div class="d-flex align-items-center justify-content-center">
                                                                <a href="{{url('admins/category',$item->id)}}/edit"
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
