@extends('layouts.backend.admin')

@section('content')
    {{-- 💡 BREADCRUMBS: កែសម្រួល URL និង Text --}}
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admins/dashboard') }}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">Contact Messages</li>
        <li class="breadcrumb-item active">@lang('lang.index')</li>
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
        <div class="alert alert-info alert-dismissible fade show" role="alert">
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
                        Contact Messages List
                    </h2>
                    {{--  <div class="panel-toolbar">  --}}
                        {{-- 💡 ADD NEW Button: URL ផ្ទាល់ --}}
                        {{--  <a href="{{ url('admins/backend-contact/create') }}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> @lang('lang.add_new')</a>
                    </div>  --}}
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                {{-- ✅ KHMER: Select Box សម្រាប់ Records Per Page --}}
                                <div class="row mb-3">
                                    <div class="col-md-auto">
                                        {{-- 💡 កែ URL ទៅ contacts --}}
                                        <form id="perPageForm" method="GET" action="{{ url('admins/backend-contact') }}">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Showing</span>
                                                </div>
                                                <select
                                                    class="form-control"
                                                    id="per_page"
                                                    name="per_page"
                                                    onchange="document.getElementById('perPageForm').submit();"
                                                >
                                                    @foreach ($perPageOptions as $option)
                                                        <option
                                                            value="{{ $option }}"
                                                            @if ($perPage == $option) selected @endif
                                                        >
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Records</span>
                                                </div>
                                            </div>

                                            {{-- 💡 រក្សាទុក Query Parameters ផ្សេងទៀត --}}
                                            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                                {{-- ចប់ Select Box --}}

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info">
                                            <thead class="">
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('lang.name')</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$item)
                                                    <tr>
                                                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->email}}</td>
                                                        <td>{{$item->phone}}</td>
                                                        <td>{{$item->subject}}</td>
                                                        <td>{{ Str::limit($item->message, 50) }}</td>

                                                        {{-- 💡 ACTION BUTTONS --}}
                                                        <td>
                                                            <div class="d-flex demo">
                                                                {{-- 💡 DELETE BUTTON --}}
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>

                                                                {{-- 💡 SHOW DETAIL BUTTON --}}
                                                                <a href="{{ url('admins/backend-contact/'.$item->id) }}" class="btn btn-sm btn-outline-info btn-icon btn-inline-block mr-1" title="View Detail"><i class="fal fa-eye"></i></a>

                                                                {{-- 💡 EDIT BUTTON --}}
                                                                <a href="{{ url('admins/backend-contact/'.$item->id.'/edit') }}" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- ✅ ផ្នែកកែសម្រួលដើម្បីបង្ហាញ Pagination Result និង Links --}}
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5">
                                                <div class="dataTables_info" id="dt-basic-example_info" role="status" aria-live="polite">
                                                    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-7">
                                                <div class="dataTables_paginate paging_simple_numbers">
                                                    <div class="float-right">
                                                        {{ $data->links('pagination::bootstrap-4') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ចប់ Pagination --}}
                                    </div>
                                </div>
                            </div>
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

    // 💡 ត្រូវប្រាកដថា URL ត្រឹមត្រូវ (admins/contacts)
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
                    // 💡 URL សម្រាប់ DELETE ត្រូវតែច្បាស់លាស់
                    url: `{{ url('/admins/backend-contact') }}/${id}`,
                    headers: { // 💡 ត្រូវបន្ថែម headers សម្រាប់ AJAX DELETE
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.mg === "success") {
                            toastr.success('@lang("lang.delete_success")', '@lang("lang.success")');
                            window.location.href = 'backend-contact'; // 💡 Redirect ទៅកាន់ URL ត្រឹមត្រូវ
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
