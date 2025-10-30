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
                            <div class="col-md-3">
                                <label class="form-label">@lang('lang.user_id') <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input id="cs_id" type="text" class="form-control @error('cs_id') is-invalid @enderror" name="cs_id" value="" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('lang.name') <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">@lang('lang.profile')</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile" name="profile">
                                    <label class="custom-file-label" for="profile">@lang('lang.choose_images')</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="single-default">@lang('lang.restrict_branch') <span class="text-danger">*</span></label>
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="branches[]" id="branches" data-select2-id="single-default" tabindex="-1" aria-hidden="true" multiple>
                                    {{-- @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_en : $item->name_en}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.access_branch') <span class="text-danger">*</span></label>
                                <select class="select2 form-control w-100 select2-hidden-accessible" name="branch_default" id="branch_default">
                                    {{-- @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_en : $item->name_en}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.email')</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="date_of_birth">@lang('lang.date_of_birth') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control datepicker @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text fs-xl">
                                            <i class="fal fa-calendar-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="single-default">@lang('lang.sex') <span class="text-danger">*</span></label>
                                <select class="select2 form-control @error('sex') is-invalid @enderror" name="sex" id="sex">
                                    <option value="1">Male</option>
                                    <option value="2">FeMale</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.password') <span class="text-danger">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="single-default">@lang('lang.role') <span class="text-danger">*</span></label>
                                <select class="select2 form-control" name="role_id" id="role_id">
                                    {{-- @foreach ($role as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('lang.confirm_password')</label>
                                <input id="password-confirm" type="password" class="form-control" name="confirmation_password" required autocomplete="new-password">
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
