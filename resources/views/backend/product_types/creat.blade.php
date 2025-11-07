@extends('layouts.backend.admin')
@section('content')
<div class="row">
    {{-- <div class="col-md-3"></div> --}}
    <div class="col-xl-6">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Product Type
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/product-type') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                </div>
                                <p class="text-danger">{!! $errors->first('name') !!}</p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea type="text" rows="10" class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/product-type')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
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
        });
    </script>
@endsection
