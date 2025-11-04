@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Shops
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/product') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
                            <p class="text-danger">{!! $errors->first('name') !!}</p>
                        </div>

                        <div class="form-group">
                            <label for="title">Logo Company</label>
                            <span class="text-danger">*</span>
                            <input type="file" name="logo_company" class="form-control" id="image-input">
                            <p class="text-danger">{!! $errors->first('logo_company') !!}</p>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_no">Home No</label>
                                    <input type="text" class="form-control" name="home_no" id="home_no" placeholder="Enter home_no" value="{{ old('home_no') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street_no">Street No</label>
                                    <input type="text" class="form-control" name="street_no" id="street_no" placeholder="Enter street No" value="{{ old('street_no') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinc">Provinc</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="provinc" name="provinc">
                                        <option value="">Please choose ctegories</option>
                                        {{-- @foreach($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <p class="text-danger">{!! $errors->first('provinc') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Category">distric</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="distric" name="distric">
                                        <option value="">Please choose sub ctegories</option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('distric') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinc">Commun</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="commun" name="commun">
                                        <option value="">Please choose ctegories</option>
                                        {{-- @foreach($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <p class="text-danger">{!! $errors->first('commun') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Category">Villag</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="villag" name="villag">
                                        <option value="">Please choose sub ctegories</option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('villag') !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" rows="10" class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/product')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                            <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">Submit</button>
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
        $(function(){
            $(document).on('change','#profile', function() {
                if (this.files && this.files[0]) {
                    let img = document.querySelector('.image_preview');
                    img.onload = () =>{
                        URL.revokeObjectURL(img.src);
                    }
                    img.src = URL.createObjectURL(this.files[0]);
                    document.querySelector(".image_preview").files = this.files;
                }
            });
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
        });
    </script>
@endsection
