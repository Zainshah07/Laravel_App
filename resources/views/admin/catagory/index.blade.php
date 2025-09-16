@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
    Catagory
@endsection
@section('header-content')
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Datatables</span> - Basic</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Category</h5>

            <button class="btn bg-primary" data-toggle="modal" data-target="#modal_form_vertical">Create</button>
        </div>

        <div class="panel panel-flat">
            <table class=" table datatable-basic" id="categoryTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>User_Id</th>
                        <th>Is_Active</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @include('admin.catagory.data-table')
                </tbody>
            </table>
        </div>


    </div>
    <!-- Vertical form modal -->
    <div id="modal_form_vertical" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Vertical form</h5>
                </div>

                <form action="" id="categoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter category name" name="name"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="is_active">Is Active</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option selected disabled> Select Status </option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /vertical form modal -->
@endsection
@section('js')
    <script src="{{ asset('../global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('../global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>


    <script src="{{ asset('../global_assets/js/demo_pages/datatables_basic.js') }}"></script>

    <script>
        $(document).ready(function() {
            // jQuery Validation
            $("#categoryForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    is_active: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Category name is required",
                        minlength: "Name must be at least 3 characters"
                    },
                    is_active: {
                        required: "Please select status"
                    }
                },
                errorClass: "is-invalid", // Add Bootstrap red border
                validClass: "is-valid", // Add Bootstrap green border
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback"); // Bootstrap class for errors
                    element.closest(".form-group").append(error);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                submitHandler: function(form) {

                    $.ajax({
                        $url: "{{ route('category.store') }}",
                        type: "POST",
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message, "Success");
                                $('#modal_form_vertical').modal('hide');
                                $('#categoryTableBody').html();
                                $('#categoryTableBody').html(response.html);
                                $('#modal_form_vertical').modal('hide');
                                $('#categoryForm')[0].reset();
                                $(".form-control").removeClass("is-valid");

                                // Optionally reload DataTable here
                                if ($.fn.DataTable.isDataTable('#yourTableID')) {
                                    $('#yourTableID').DataTable().ajax.reload();
                                }
                            }

                        },

                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    toastr.error(value[0], "Validation Error");
                                });
                            } else {
                                toastr.error("Something went wrong. Try again.", "Error");
                            }
                        }
                    });

                    return false;

                },
                invalidHandler: function() {
                    toastr.error("Please fill in all required fields correctly.", "Error");
                }

            });
        });
    </script>
@endsection
