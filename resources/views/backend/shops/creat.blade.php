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
                    <form method="POST" action="{{ url('admins/shops') }}" enctype="multipart/form-data" novalidate>
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
                            <input type="file" name="logo_company" id="logo_company" class="form-control" id="image-input">
                            <p class="text-danger">{!! $errors->first('logo_company') !!}</p>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_no">Home No</label>
                                    <input type="text" class="form-control" name="home_no" id="home_no" placeholder="Enter home no" value="{{ old('home_no') }}">
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
                                    <select class="form-control select2" id="province" name="province">
                                        <option value="">Select provice</option>
                                        @foreach($provice as $item)
                                            <option value="{{ $item->code  }}">{{ $item->english }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{!! $errors->first('province') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Category">district</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="district" name="district">
                                        <option value="">Select district </option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('district') !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinc">Commun</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="commune" name="commune">
                                        <option value="">Select commun</option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('commune') !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Category">Villag</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" id="village" name="village">
                                        <option value="">Select village </option>
                                    </select>
                                    <p class="text-danger">{!! $errors->first('village') !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Enter facebook" value="{{ old('facebook') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">website</label>
                                    <input type="text" class="form-control" name="website" id="website" placeholder="Enter Website" value="{{ old('website') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" rows="10" class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/shops')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
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
            $("#province").on("change", function(){
                let id = $("#province").val() ?? $("#province").val();
                let optionSelect = "Province";
                $('#district').html('<option selected disabled> -- @lang("lang.select") --</option>');
                $('#commune').html('<option selected disabled> -- @lang("lang.select") --</option>');
                $('#village').html('<option selected disabled> -- @lang("lang.select") --</option>');
                showProvince(id, optionSelect);
            });
            $("#district").on("change", function(){
                let id = $("#district").val() ?? $("#district").val();
                let optionSelect = "District";
                $('#commune').html('<option selected disabled> -- @lang("lang.select") --</option>');
                $('#village').html('<option selected disabled> -- @lang("lang.select") --</option>');
                showProvince(id, optionSelect);
            });
            $("#commune").on("change", function(){
                let id = $("#commune").val() ?? $("#commune").val();
                let optionSelect = "Commune";
                $('#village').html('<option selected disabled> -- @lang("lang.select") --</option>');
                showProvince(id, optionSelect);
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
        function showProvince(id, optionSelect){
            let url = "";
            let data = {
                "_token": "{{ csrf_token() }}",
            };
            // Address
            if (optionSelect == "Province") {
                url = "{{url('admins/district')}}"
                data.province = id
            }else if (optionSelect == "District") {
                url = "{{url('admins/commune')}}"
                data.district = id
            }else if (optionSelect == "Commune") {
                url = "{{url('admins/village')}}"
                data.commune = id
            };
            $.ajax({
                type: "POST",
                url,
                data,
                dataType: "JSON",
                success: function (response) {
                    var data = response.data;
                    if (data != '') {
                        let option = {value: "",text: ""}
                        $.each(data, function(i, item) {
                            option = {
                                value: item.code,
                                text: item.english,
                            }
                            if (optionSelect == "Province") {
                                $('#district').append($('<option>', option));
                            }else if(optionSelect == "District"){
                                $('#commune').append($('<option>', option));
                            }else if (optionSelect == "Commune") {
                                $('#village').append($('<option>', option));
                            }
                        });
                    }
                }
            });
        }
    </script>
@endsection
