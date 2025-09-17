@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
    Sub-Category
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Sub-Category</h5>

            <button class="btn bg-primary" data-toggle="modal" id="js-add-sub-category-button">Create</button>
        </div>
        <div class="panel panel-flat">
            <table class=" table datatable-basic" id="subCategoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="js-subcategory-table-body">
                    @include('admin.sub-catagory.data-table')
                </tbody>
            </table>
        </div>


    </div>

    <!-- Vertical form modal -->
    <div id="js-add-sub-category-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="js-modal-title">Add Sub-Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" id="subCategoryForm">
                    <input type="hidden" name="sub_category_id" id="js-sub-category-id" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter the sub category" name="name"
                                        class="form-control" id="js-sub-category-name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Choose Category</label>
                                    <div>
                                        <select class="form-control" id="js-category-dropdown" name="category_id" required>
                                            <option value="" selected disabled>Select Category</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Is Active</label>
                                    <select name="is_active" id="js-is-active" class="form-control">
                                        <option selected disabled> Select Status </option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {


            // add new category start here
            $('#subCategoryForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    category_id: {
                        required: true
                    },
                    is_active: {
                        required: true
                    }

                },

                messages: {
                    name: {
                        required: 'Sub category name required',
                        minlength: 'name must have atleast 3 characters'
                    },
                    category_id: {
                        required: 'must choose a category'
                    },
                    is_active: {
                        required: 'select the status'
                    }

                },

                errorElement: 'small',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                invalidHandler: function(event, validator) {
                    if (validator.numberOfInvalids()) {
                        toastr.error("Please correct the highlighted errors before submitting.");
                    }
                },

                submitHandler: function(form) {
                    $.ajax({
                        url: "{{ route('sub-category.store') }}",
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        },
                        success: function(response) {
                            console.log(response);
                            if(response.success){
                            toastr.success(response.message, "success");
                            $("#js-add-sub-category-modal").modal('hide');
                            $("#js-subcategory-table-body").html('');
                            $("#js-subcategory-table-body").html(response.html);
                            $("#subCategoryForm")[0].reset();
                            $(".form-control").removeClass("is-valid");
                            }
                            else{
                                toastr.error(response.message, "error");
                            }
                        }
                    });

                }
            });

            // add new category end here


            // edit category start here
            $(document).on('click', '#js-edit-sub-category-button', function() {
                event.preventDefault();
                var id = $(this).data("id");
                var href = "{{ route('sub-category.edit', ':id') }}".replace(':id', id);
                $.ajax({
                    url: href,
                    type: "GET",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) 
                    {
                        console.log(response);
                        if(response.success){
                            getDynamicDropdownData("{{ route('get.categories') }}", "#js-category-dropdown");
                            $("#js-sub-category-id").val(response.data.id);
                            $("#js-sub-category-name").val(response.data.name);
                            $("#js-is-active").val(response.data.is_active);
                            $("#js-category-dropdown").val(response.data.category_id).trigger("change");
                            $("#js-modal-title").text("Edit Sub-Category");
                            $("#js-add-sub-category-modal").modal("show");
                        }
                        else{
                            toastr.error(response.message, "error");
                        }
                    }
                });
                return false;
            });
            // edit category end here

            // delete category start here
            $(document).on('click', '#js-delete-sub-category-button', function() {
                event.preventDefault();
                var id = $(this).data("id");
                
                if (confirm("Are you sure you want to delete this sub-category?")) {
                    var href = "{{ route('sub-category.destroy', ':id') }}".replace(':id', id);
                    $.ajax({
                        url: href,
                        type: "DELETE",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        },
                        success: function(response) {
                            console.log(response);
                            if(response.success){
                                toastr.success(response.message, "success");
                                $("#js-subcategory-table-body").html('');
                                $("#js-subcategory-table-body").html(response.html);
                            }
                            else{
                                toastr.error(response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error("An error occurred while deleting the sub-category.", "error");
                        }
                    });
                }
                return false;
            });
            // delete category end here

            $("#js-add-sub-category-button").click(function() {
                getDynamicDropdownData("{{ route('get.categories') }}", "#js-category-dropdown");
                $("#js-modal-title").text("Add Sub-Category");
                $("#js-sub-category-id").val("");
                $("#subCategoryForm")[0].reset();
                $(".form-control").removeClass("is-valid is-invalid");
                $("#js-add-sub-category-modal").modal("show");
            });

        });
    </script>
@endsection
