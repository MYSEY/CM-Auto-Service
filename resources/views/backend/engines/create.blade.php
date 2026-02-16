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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Make">Make</label>
                                <span class="text-danger">*</span>
                                <select class="form-control req" id="category_id" name="category_id">
                                    <option value="">Please choose make</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger error-category_id"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Model">Model</label>
                                <span class="text-danger">*</span>
                                <select class="form-control sub_category" id="sub_category_id" name="sub_category_id">
                                    <option value="">Please choose model</option>
                                </select>
                                <small class="text-danger error-sub_category_id"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="engine">Engine Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter part name">
                                <small class="text-danger error-name"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="part_number">Part Number</label>
                                <input type="text" id="part_number" name="part_number" class="form-control" value="{{ old('part_number') }}" placeholder="Enter part number">
                            </div>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{ url('admins/engine') }}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">
                                Cancel
                            </a>
                            <a href="javascript:void(0);" id="btnSubmit" class="btn btn-outline-success btn-pills waves-effect waves-themed">Submit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function(){
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

        $(document).on('click', '#btnSubmit', function() {
            let btn = $(this); // បង្កើត variable តំណាងឱ្យប៊ូតុងដែលចុច

            // ១. Disable ប៊ូតុងភ្លាមៗ និងបង្ហាញ Loading
            btn.addClass('disabled').attr('disabled', true);
            let originalText = btn.html(); // រក្សាទុកអក្សរដើម (Submit)
            btn.html('<i class="fal fa-spinner fa-spin"></i> Processing...');

            // លុប Error message ចាស់ៗចោលមុននឹងផ្ញើ Request ថ្មី
            $('.text-danger').text('');

            $.ajax({
                type: "POST",
                url: "{{ url('admins/engine') }}",
                data: {
                    _token: "{{ csrf_token() }}", // កុំភ្លេចថែម CSRF token សម្រាប់ការប្រើ AJAX POST
                    category_id : $("#category_id").val(),
                    sub_category_id : $("#sub_category_id").val(),
                    name : $("#name").val(),
                    part_number : $("#part_number").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success');
                        $("#name").val('');
                        $("#part_number").val('');
                    } else {
                        toastr.error('Error', 'Fail');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('.error-' + key).text(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong!', 'Error');
                    }
                },
                complete: function() {
                    // ២. នៅពេលដំណើរការចប់ (ទោះជោគជ័យ ឬបរាជ័យ) ត្រូវ Enable ប៊ូតុងមកវិញ
                    btn.removeClass('disabled').removeAttr('disabled');
                    btn.html(originalText);
                }
            });
        });
    });
</script>
@endsection
