@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-8 mx-auto">
        <div id="panel-2" class="panel">
            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 65px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-plus-circle text-primary"></i>
                    </span>
                    Create New <span class="fw-300 text-muted ml-1">Slider</span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-4">
                    <form method="POST" action="{{ url('admins/slide') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="title" class="font-weight-bold text-dark">Slider Title (Optional)</label>
                            <input type="text" class="form-control rounded-lg" name="title" id="title" placeholder="Enter slider title (e.g. Special Promotion)" value="{{ old('title') }}">
                            <small class="text-danger font-weight-bold">{!! $errors->first('title') !!}</small>
                        </div>

                        <div class="form-group">
                            <label for="image_slider" class="font-weight-bold text-dark">Slider Image <span class="text-danger">*</span></label>
                            <div class="figma-dropzone p-4 text-center border rounded-lg" style="background: #f8fafc; border: 2px dashed #cbd5e1 !important; cursor: pointer;">
                                <i class="fal fa-cloud-upload fa-3x text-primary mb-2 d-block"></i>
                                <span class="font-weight-bold text-dark d-block mb-1">Click or drag image file here to upload</span>
                                <span class="text-muted fs-xs d-block mb-3">Supports JPG, PNG, WEBP high-resolution banner images</span>
                                <input type="file" name="image_slider" class="form-control-file d-block mx-auto" id="image_slider" required accept="image/*">
                            </div>
                            <small class="text-danger font-weight-bold">{!! $errors->first('image_slider') !!}</small>
                            <div id="image-preview-container" class="mt-3"></div>
                        </div>

                        <div class="form-group mb-0 text-right mt-4 pt-3 border-top">
                            <a href="{{url('admins/slide')}}" class="btn btn-outline-secondary rounded-pill px-4 mr-2">Cancel</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm">
                                <i class="fal fa-check-circle mr-1"></i> Save Slider
                            </button>
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
            $(document).on('change','#image_slider', function() {
                const previewContainer = $('#image-preview-container');
                previewContainer.empty();

                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append(`<img src="${e.target.result}" alt="Slider Image Preview" style="max-width: 200px; height: auto; border: 1px solid #ccc; padding: 5px;">`);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var btn = $('#submit-btn');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(res) {
                        btn.prop('disabled', false).text('Submit');
                        if (typeof toastr !== 'undefined') {
                            toastr.success(res.message || 'Create Slider successfully.');
                        }
                        if (res.redirect) {
                            setTimeout(function() {
                                window.location.href = res.redirect;
                            }, 800);
                        }
                    },
                    error: function(err) {
                        btn.prop('disabled', false).text('Submit');
                        var msg = 'Create Slider failed.';
                        if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.error(msg);
                        } else {
                            alert(msg);
                        }
                    }
                });
            });
        });
    </script>
@endsection
