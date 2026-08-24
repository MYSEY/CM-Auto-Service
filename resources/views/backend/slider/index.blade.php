@extends('layouts.backend.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel mb-g">
            <div class="panel-hdr bg-white border-bottom-0 h6 font-weight-bold text-uppercase" style="min-height: 70px; padding: 0 1.5rem;">
                <h2 class="text-primary d-flex align-items-center">
                    <span class="p-2 bg-primary-50 rounded-circle mr-2">
                        <i class="fal fa-images text-primary"></i>
                    </span>
                    Sliders <span class="fw-300 text-muted ml-1">Management</span>
                </h2>
                <div class="panel-toolbar">
                    <a href="{{ url('admins/slide/create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm font-weight-bold">
                        <i class="fal fa-plus-circle mr-1"></i> Add New Slider
                    </a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-3">
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="dt-basic-example" class="table table-hover w-100 dataTable dtr-inline m-0" role="grid">
                            <thead class="bg-light">
                                <tr class="text-uppercase fs-nano text-muted">
                                    <th style="width: 60px;" class="pl-4">#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th style="width: 180px;">Status</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                    <tr id="slider-row-{{ $item->id }}" class="align-middle">
                                        <td class="align-middle pl-4 font-weight-bold text-muted">{{ $key + 1 }}</td>
                                        <td class="align-middle">
                                            @if ($item->image_slider)
                                                <img src="{{ asset('images/sliders/' . $item->image_slider) }}" class="rounded shadow-sm border" style="object-fit: cover; width: 140px; height: 70px;" alt="Slider Image">
                                            @else
                                                <span class="badge badge-secondary">No Image</span>
                                            @endif
                                        </td>
                                        <td class="align-middle font-weight-bold text-dark">
                                            {{ $item->title ?: 'N/A' }}
                                        </td>
                                        <td class="align-middle">
                                            <select class="form-control form-control-sm btn-status rounded-pill" data-id="{{ $item->id }}" style="font-weight: 600;">
                                                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Publish (ផ្សព្វផ្សាយ)</option>
                                                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Pending (រង់ចាំ)</option>
                                                <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Un-Publish (មិនផ្សព្វផ្សាយ)</option>
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                                                <a href="{{url('admins/slide',$item->id)}}/edit" class="btn btn-icon btn-xs btn-outline-primary rounded-circle shadow-sm" title="Edit">
                                                    <i class="fal fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);" onclick="deleteData({{$item->id}})" class="btn btn-icon btn-xs btn-outline-danger rounded-circle shadow-sm" title="Delete">
                                                    <i class="fal fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
@section('script')
<script>
    // --- STATUS CHANGE LOGIC (មុខងារប្តូរស្ថានភាព) ---
    $(document).ready(function(){
        // ចាប់យកព្រឹត្តិការណ៍នៅពេល Select Box មានការផ្លាស់ប្តូរ
        $(".btn-status").on('change',function(){
            var publish = $(this).val(); // តម្លៃ Status ថ្មី (1, 0, ឬ 2)
            var id = $(this).data('id'); // ID របស់ Slider

            $.ajax({
                type: "POST",
                // URL សម្រាប់ប្តូរ Status (ត្រូវផ្គូផ្គងនឹង Route ក្នុង web.php)
                url: "{{ url('admins/slide/change/status') }}/" + id,
                data: {
                    status: publish,
                    _token: "{{ csrf_token() }}" // CSRF token សម្រាប់សុវត្ថិភាព
                },
                dataType: "JSON",
                success: function (response) {
                    // response.msg ត្រូវតែ return ពី Controller ថាជា 'success'
                    if (response.msg === 'success') {
                        toastr.success('Slider status updated successfully!');
                    } else {
                        toastr.error('Failed to update status.');
                    }
                },
                error: function (xhr) {
                    toastr.error('Something went wrong with the status update.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
    const deleteData = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    // URL សម្រាប់ DELETE (ប្រើ RESTful naming)
                    url: `{{url('/admins/slide')}}/${id}`,
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE" // ប្រើ Method Spoofing សម្រាប់ DELETE
                    },
                    success: function (data) {
                        // Controller គួរតែ return {'msg': 'success'}
                        if (data.msg === "success") {
                            toastr.success("Your slider has been deleted.", "Deleted!");
                            // លុបជួរដេក (Row) ពីតារាងភ្លាមៗដោយមិនចាំបាច់ Reload ទំព័រ
                            $(`#slider-row-${id}`).remove();
                        } else {
                            toastr.error("Deletion failed.", "Error");
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong on the server.", "Error");
                    }
                });
            }
        });
    }
</script>
@endsection
