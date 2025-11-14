@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Sliders
                </h2>
                <div class="panel-toolbar">
                    {{-- ប៊ូតុងបន្ថែមថ្មី (Add New Button) --}}
                    <a href="{{ url('admins/slide/create') }}" class="btn btn-sm btn-success waves-effect waves-themed btn-sm mr-1">
                        <i class="fal fa-plus mr-1"></i> Add New
                    </a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    {{-- លទ្ធផល Notification ពី Session (Success Message) --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- តារាងបង្ហាញទិន្នន័យ (Data Table) --}}
                                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline" role="grid">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Loop បង្ហាញទិន្នន័យ Slider នីមួយៗ --}}
                                            @foreach ($data as $key=>$item)
                                                <tr id="slider-row-{{ $item->id }}">
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                        @if ($item->image_slider)
                                                            {{-- បង្ហាញរូបភាព Slider ពី Storage Link --}}
                                                            <img src="{{ asset('storage/' . $item->image_slider) }}"
                                                                style="object-fit: cover;width: 150px;height: 80px;"
                                                                alt="Slider Image">
                                                        @endif
                                                    </td>
                                                    <td>{{$item->title}}</td>
                                                    <td>{{$item->type}}</td>
                                                    <td>{{$item->link}}</td>
                                                    <td>
                                                        {{-- Select Box សម្រាប់ប្តូរ Status តាម AJAX --}}
                                                        <select class="form-control btn-status" data-id="{{ $item->id }}">
                                                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Publish</option>
                                                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Pending</option>
                                                            <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Un-Publish</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex demo">
                                                            {{-- ប៊ូតុងលុប (Delete Button) ប្រើ SweetAlert2 --}}
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-sm btn-outline-danger btn-icon btn-inline-block mr-1"
                                                                onclick="deleteData({{$item->id}})"
                                                                title="Delete Record">
                                                                <i class="fal fa-times"></i>
                                                            </a>
                                                            {{-- ប៊ូតុងកែប្រែ (Edit Button) --}}
                                                            <a href="{{url('admins/slide',$item->id)}}/edit"
                                                                class="btn btn-sm btn-outline-primary btn-icon btn-inline-block mr-1"
                                                                title="Edit">
                                                                <i class="fal fa-edit"></i>
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
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- SweetAlert2 (សម្រាប់ Delete Confirmation) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- jQuery (តម្រូវការសម្រាប់ AJAX) --}}
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

{{-- **ចំណាំ៖ ត្រូវប្រាកដថាអ្នកបានបញ្ចូល Toastr JS និង Summernote JS នៅក្នុង Layout មេរបស់អ្នក**
   (ដូចដែលបានបញ្ជាក់ពីមុន Toastr ត្រូវបានប្រើដោយ `toastr.success` ហើយ Summernote ត្រូវបានហៅដោយកូដផ្សេង) --}}

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

    // --- DELETE LOGIC (មុខងារលុបទិន្នន័យ) ---
    // មុខងារនេះត្រូវបានហៅដោយ onclick="deleteData({{ $item->id }})"
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
