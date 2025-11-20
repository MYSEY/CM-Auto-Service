@extends('layouts.backend.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-container collapse show">
                    <div class="panel-hdr ">
                        <h2>
                            ➕ Sub-Category
                        </h2>
                    </div>
                    <div class="panel-content">
                        <form action="{{url('admins/sub-category')}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="product_category_id">Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('product_category_id') is-invalid @enderror" id="product_category_id" name="product_category_id" required>
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Sub Category Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter Sub-Category Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Description (Max 200 characters)</label>
                                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Sub-Category brief description">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">Status (Active/Inactive)</label>
                                            <div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="is_active_1" name="is_active" class="custom-control-input" value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_active_1">Active</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="is_active_0" name="is_active" class="custom-control-input" value="0" {{ old('is_active', 1) == 0 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_active_0">Inactive</label>
                                                </div>
                                            </div>
                                            @error('is_active')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-4">
                            {{-- Action Buttons --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2" style="text-align: right;">
                                        <a href="{{url('admins/sub-category')}}" class="btn btn-outline-secondary btn-pills waves-effect waves-themed">Cancel</a>
                                        <button type="submit" class="btn btn-outline-success btn-pills waves-effect waves-themed">Submit</button>
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
