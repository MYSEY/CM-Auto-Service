@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        @lang('lang.users')
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/users') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.name') <span class="text-primary">*</span></label>
                                <div class="custom-file">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.user_name') <span class="text-primary">*</span></label>
                                <div class="custom-file">
                                    <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.email')</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="single-default">@lang('lang.sex') <span class="text-primary">*</span></label>
                                <select class="select2 form-control @error('sex') is-invalid @enderror" name="sex" id="sex">
                                    <option value="1">Male</option>
                                    <option value="2">FeMale</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.password') <span class="text-primary">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.confirm_password')</label>
                                <input id="password-confirm" type="password" class="form-control" name="confirmation_password" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="single-default">@lang('lang.role') <span class="text-primary">*</span></label>
                                <select class="select2 form-control" name="role_id" id="role_id">
                                    <option value="1">Administrator</option>
                                    <option value="2">Staff</option>
                                    <option value="3">Develop</option>
                                    {{-- @foreach ($role as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">@lang('lang.profile')</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile" name="profile">
                                    <label class="custom-file-label" for="profile">@lang('lang.choose_images')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/users')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">@lang('lang.cancel')</a>
                            <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">@lang('lang.submit')</button>
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
        });
    </script>
@endsection
