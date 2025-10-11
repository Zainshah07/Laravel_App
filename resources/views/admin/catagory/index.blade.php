@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
    Catagory
@endsection
@section('header-content')

@endsection
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Category</h5>

            <button class="btn bg-primary" id="js-add-category-button" data-toggle="modal" data-target="#js-add-category-modal">Create</button>
        </div>

        <div class="panel panel-flat">
            <table class=" table datatable-basic" id="categoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @include('admin.catagory.data-table')
                </tbody>
            </table>
        </div>


    </div>
    <!-- Vertical form modal -->
    <div id="js-add-category-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title" id="js-modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <form action="" id="categoryForm">
                    @csrf
                    <input type="hidden" name="category_id" id="js-category-id" value="">  
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter category name" name="name"
                                       id="js-category-name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="is_active">Is Active</label>
                                    <select name="is_active" id="js-is_active" class="form-control">
                                        <option selected disabled> Select Status </option>
                                        <option value="1" >Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button id="js-submit-button"class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /vertical form modal -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $("#js-add-category-button").click(function(){
                $("#categoryForm")[0].reset();
            });

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
                errorClass: "is-invalid",
                validClass: "is-valid",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
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
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message, "Success");
                                $('#js-add-category-modal').modal('hide');
                                $('#categoryTableBody').html();
                                $('#categoryTableBody').html(response.html);
                                $("#categoryForm")[0].reset();
                                $(".form-control").removeClass("is-valid");
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

            //Edit Category starts here
            $(document).on('click','#js-edit-category-button',function(){
                event.preventDefault();
                var id = $(this).data("id");
                var href = "{{ route('category.edit',':id') }}".replace(':id',id);

                $.ajax({
                    url:href,
                    type:"GET",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success:function(response){
                        if(response.success){
                            $("#js-category-id").val(response.data.id);
                            $("#js-category-name").val(response.data.name);
                            $("#js-is_active").val(response.data.is_active);
                            $("#js-modal-title").text("Edit Category");
                            $("#js-submit-button").text("Update");
                            $("#js-add-category-modal").modal('show')
                        }
                        else{
                            toastr.error(response.message,"error");
                        }

                    }
                });
                return false;
            });
            // Edit Category ends here

            //Delete Category Starts here
            $(document).on('click','#js-delete-category-button',function(){
                event.preventDefault();
                var id = $(this).data("id");

                Swal.fire({
                    title:"are you sure?",
                    text:"You want to delete this category",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result)=>{
                    if(result.isConfirmed){
                        var href = "{{ route('category.destroy',':id') }}".replace(':id',id);
                        $.ajax({
                            url:href,
                            type:"DELETE",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                            },
                            success:function(response){
                                console.log(response);
                                if(response.success){
                                    toastr.success(response.message, "success");
                                    $('#categoryTableBody').html('');
                                    $('#categoryTableBody').html(response.html);
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
                });

            });
            // Delete Category ends here
        });
    </script>
@endsection
