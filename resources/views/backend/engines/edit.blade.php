@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr ">
                        <h2>
                            Engines
                        </h2>
                    </div>
                    <div class="panel-content">
                        <form action="{{ url('admins/engine', $data->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Category">Make</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose make</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $data->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('category_id') !!}</p>
                                </div>
                            </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id" required>
                                            <option value="">Select a Sub Category</option>
                                            @foreach ($subCategory as $item)
                                                <option value="{{ $item->id }}" {{ $data->sub_category_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Engines Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $data->name }}" required placeholder="Enter Sub-Category Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Part Number</label>
                                        <input type="text" id="part_number" name="part_number" class="form-control" value="{{ $data->part_number }}" required placeholder="Enter part number">
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2" style="text-align: right;">
                                        <a href="{{url('admins/engine')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                                        <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).on('change','#category_id',function(){
                var category_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ url('admins/product/category/onchange') }}",
            data: {
                category_id:category_id
            },
            dataType: "JSON",
            success: function (response) {
                $(".sub_category").empty();
                $(".sub_category").empty().append('<option value="">Please Select</option>');
                $.each(response.data, function(index, item)
                {
                    $(".sub_category").append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            }
        });
    });
    $(document).on('change','#sub_category_id',function(){
        var sub_category_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ url('admins/product/sub-category/onchange') }}",
            data: {
                sub_category_id:sub_category_id
            },
            dataType: "JSON",
            success: function (response) {
                $(".engine_id").empty();
                $(".engine_id").empty().append('<option value="">Please Select</option>');
                $.each(response.data, function(index, item)
                {
                    $(".engine_id").append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            }
        });
    });
</script>
@endsection

