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
                    <a href="{{url('admins/product/create')}}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1"><i class="fal fa-plus mr-1"></i> Add New</a>
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
                                                <th>ProductPhoto</th>
                                                <th>Name</th>
                                                <th>ProductType</th>
                                                <th>Category</th>
                                                <th>SubCategory</th>
                                                <th>Engine</th>
                                                <th>SerialNumber</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Year</th>
                                                 <th>Number</th>
                                                <th>DiscountPrice</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key=>$item)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                        @if ($item->product_photo)
                                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" style="object-fit: cover;width: 100px;height: 50px;" alt="product">
                                                        @endif
                                                    </td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->productType ? $item->productType->name : ''}}</td>
                                                    <td>{{ $item->category ? $item->category->name : '' }}</td>
                                                    <td>{{ $item->subCategory ? $item->subCategory->name : '' }}</td>
                                                    <td>{{ $item->proEngine ? $item->proEngine->name:''}}</td>
                                                    <td>{{ $item->subCategory ? $item->subCategory->serial_number : '' }}</td>
                                                    <td>{!! $item->description !!}</td>
                                                    <td>{{$item->PriceFormat}}</td>
                                                    <td>{{$item->year}}</td>
                                                    <td>{{$item->number}}</td>
                                                    <td>{{$item->DiscountPriceFormat}}</td>
                                                    <td>
                                                        <select class="form-control" id="btnStatus">
                                                            <option value="1" {{ $item->publish==1 ? 'selected' : '' }}>Publish</option>
                                                            <option value="0" {{ $item->publish==0 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $item->publish==2 ? 'selected' : '' }}>Un-Publish</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex demo">
                                                            <input type="text" value="{{ $item->id }}" id="id" hidden>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1" onclick="deleteData({{$item->id}})" title="Delete Record"><i class="fal fa-times"></i></a>
                                                            <a href="{{url('admins/product',$item->id)}}/edit" class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1" title="Edit"><i class="fal fa-edit"></i></a>
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
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
@endsection
@section('script')
<script>
    $(function(){
        $("#btnStatus").on('change',function(){
            var publish = $(this).val();
            var id = $("#id").val();
            $.ajax({
                type: "POST",
                url: "{{ url('admins/product/change/publish') }}/" + id,
                data: {
                    publish:publish,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.msg === 'success') {
                        toastr.success('Publish product successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error('Failed to update status.');
                    }
                },
                error: function (xhr) {
                    toastr.error('Something went wrong.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
    const deleteData = (id)=>{
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: `Cancel`,
            confirmButtonText: `Deleted`,
        }).then(function(result)
        {
            if (result.value)
            {
                $.ajax({
                    type: "DELETE",
                    url: `{{url('/admins/product/${id}')}}`,
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
