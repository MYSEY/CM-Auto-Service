@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr bg-success-600">
                        <h2>
                            @lang('lang.company_info')
                        </h2>
                    </div>
                    <div class="panel-content">
                        <form action="{{url('admins/company', $data->id)}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4" style="display: flex;justify-content: center;">
                                    <div class="col-md-6">
                                        <div class="form-group mt-1">
                                            @if ($data->company_logo == null)
                                                <img src="{{ asset('images/fetch_photo/001-avatar.png') }}" class=" imagestaff_preview shadow-3 img-thumbnail " alt="article photo" style="width: 150px;height:150px;border-radius: 50%;border: 1px solid #08ff67;">
                                            @else
                                                <img src="{{ $data->company_logo }}" class=" imagestaff_preview shadow-3 img-thumbnail " alt="article photo" style="width: 150px;height:150px;border-radius: 50%;border: 1px solid #08ff67;">
                                            @endif
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="company_logo" name="company_logo">
                                            <label class="custom-file-label" for="company_logo">@lang('lang.choose_images')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="name_kh">@lang('lang.name_kh') <span class="text-danger">*</span></label>
                                        <input type="text" id="name_kh" name="name_kh" class="form-control @error('name_kh') is-invalid @enderror" value="{{$data->name_kh}}">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="name_en">@lang('lang.name_en') <span class="text-danger">*</span></label>
                                        <input type="text" id="name_en" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{$data->name_en}}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="address_kh">@lang('lang.address_kh') <span class="text-danger">*</span></label>
                                        <input type="text" id="address_kh" name="address_kh" class="form-control @error('address_kh') is-invalid @enderror" value="{{$data->address_kh}}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="address_en">@lang('lang.address_en') <span class="text-danger">*</span></label>
                                        <input type="text" id="address_en" name="address_en" class="form-control @error('address_en') is-invalid @enderror" value="{{$data->address_en}}">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="Phone_Number">@lang('lang.phone_number') <span class="text-danger">*</span></label>
                                        <input type="number" id="Phone_Number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{$data->phone_number}}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="email">@lang('lang.email') <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$data->email}}">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label class="form-label" for="website">@lang('lang.website') <span class="text-danger">*</span></label>
                                        <input type="text" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{$data->website}}">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2" style="text-align: right;">
                                            <input type="hidden" name="old_profile" id="old_profile" value="{{$data->company_logo}}">
                                            <input type="hidden" name="id" value="{{ $data->id}}">
                                            <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">@lang('lang.update')</button>
                                        </div>
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
       $(document).on('change','#company_logo', function() {
            if (this.files && this.files[0]) {
                let img = document.querySelector('.imagestaff_preview');
                img.onload = () =>{
                    URL.revokeObjectURL(img.src);
                }
                img.src = URL.createObjectURL(this.files[0]);
                document.querySelector(".imagestaff_preview").files = this.files;
            }
        });
    </script>
@endsection
