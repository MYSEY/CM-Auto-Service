@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Products
                </h2>
                <div class="panel-toolbar">
                    <a href="{{url('admins/users/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> @lang('lang.add_new')</a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <!-- datatable start -->
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid" aria-describedby="dt-basic-example_info" style="width: 1163px;">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('lang.product_photo')</th>
                                                <th>@lang('lang.name')</th>
                                                <th>@lang('lang.description')</th>
                                                <th>@lang('lang.category')</th>
                                                <th>@lang('lang.status')</th>
                                                <th>@lang('lang.price')</th>
                                                <th>@lang('lang.discount_price')</th>
                                                <th>@lang('lang.delivery_note')</th>
                                                <th>@lang('lang.content')</th>
                                                <th>@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key=>$item)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                    {{$item->product_photo}}
                                                    </td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td>{{$item->category}}</td>
                                                    <td>{{$item->status}}</td>
                                                    <td>{{$item->price}}</td>
                                                    <td>{{$item->discount_price}}</td>
                                                    <td>{{$item->delivery_note}}</td>
                                                    <td>{{$item->content}}</td>
                                                    <td>
                                                        <div class="d-flex demo">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>
                                                            <a href="{{url('admins/users',$item->id)}}/edit" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
</div>

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
                            toastr.error("Your file has been deleted.", "Deleted!");
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
