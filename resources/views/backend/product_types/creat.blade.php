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
                                <label class="form-label">Name <span class="text-primary">*</span></label>
                                <div class="custom-file">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                </div>
                                <p class="text-primary">{!! $errors->first('name') !!}</p>
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
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-pills waves-effect waves-themed">Submit</button>
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
        $(document).ready(function() {
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
                            toastr.success(res.message || 'Product type created successfully!');
                        }
                        if (res.redirect) {
                            setTimeout(function() {
                                window.location.href = res.redirect;
                            }, 800);
                        }
                    },
                    error: function(err) {
                        btn.prop('disabled', false).text('Submit');
                        var msg = 'Product type creation failed.';
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
