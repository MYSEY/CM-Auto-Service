@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-8 mx-auto">
        <div id="panel-2" class="panel">
            <div class="panel-container collapse show">
                <div class="panel-hdr">
                    <h2>
                        Create New Slider
                    </h2>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="POST" action="{{ url('admins/slide') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="title">Title (Optional)</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter slider title" value="{{ old('title') }}">
                            <p class="text-danger">{!! $errors->first('title') !!}</p>
                        </div>

                        <div class="form-group">
                            <label for="image_slider">Slider Image</label>
                            <span class="text-danger">*</span>
                            <input type="file" name="image_slider" class="form-control" id="image_slider" required accept="image/*">
                            <p class="text-danger">{!! $errors->first('image_slider') !!}</p>
                            <div id="image-preview-container" style="margin-top: 10px;"></div>
                        </div>
                        <div class="form-group mb-0" style="text-align: right;">
                            <a href="{{url('admins/slide')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
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
            // Simplified script to show image preview for the main slider image
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

            // The AJAX logic for category/sub-category is removed as it's not needed for the simple Slider model
        });
    </script>
@endsection
