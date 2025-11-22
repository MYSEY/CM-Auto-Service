@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>Add New Engine</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form action="{{ url('admins/engine') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Make → Model → Engine Row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Make">Make</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please choose make</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Model">Model</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control sub_category" id="sub_category_id" name="sub_category_id">
                                        <option value="">Please choose model</option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('sub_category_id') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label class="form-label" for="engine">Engine Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ old('name') }}" placeholder="Enter part name">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Part Number -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="part_number">Part Number</label>
                                    <input type="text" id="part_number" name="part_number" class="form-control"
                                           value="{{ old('part_number') }}" placeholder="Enter part number">
                                    @error('part_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4">

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ url('admins/engine') }}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">
                                    Submit
                                </button>
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
</script>
@endsection
