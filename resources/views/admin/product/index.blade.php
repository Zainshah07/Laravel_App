@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
    Products
@endsection
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Products</h5>

            <button class="btn bg-primary" data-toggle="modal" id="js-add-product-button">Create</button>
        </div>
        <div class="panel panel-flat" style="overflow-x: auto">
            <table class=" table datatable-basic" id="ProductTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Images</th>
                        <th>Unit Price</th>
                        <th>CPU (cost-per-unit)</th>
                        <th>Is Active</th>
                         <th>Actions</th>


                    </tr>
                </thead>
                <tbody id="js-product-table-body">
                    @include('admin.product.data-table')
                </tbody>
            </table>
        </div>


    </div>

    <!-- Vertical form modal -->
    <div id="js-product-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="js-modal-title">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" id="productForm" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="js-product-id" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter product name" name="name"
                                        class="form-control" id="js-product-name">
                                </div>


                                <div class="col-sm-6">
                                    <label>Quantity</label>
                                    <input type="number" placeholder="Enter product quantity" name="quantity"
                                        id="js-product-quantity" class="form-control" id="js-product-quantity">
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
                                    <label>Choose Sub-Category</label>
                                    <div>
                                        <select class="form-control" id="js-sub_category-dropdown" name="sub_category_id"
                                            >
                                            <option value="" selected disabled>Select Sub-Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col-sm-4">
                                    <label>Unit Price</label>
                                    <div>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            name="unit_price" placeholder="Enter Unit Price" id="js-unit-price">
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <label>Cost Price Per Unit</label>
                                    <div>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            id="js-cost-per-unit-price" name="cost_price_per_unit"
                                            placeholder="Enter Cost Price Per Unit" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label>Is Active</label>
                                    <select name="is_active" id="js-is-active" class="form-control">
                                        <option selected disabled> Select Status </option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Upload Product Image</label>
                                    <input type="file" accept="image/*" name="images" id="js-product-images" class="form-input-styled">
                                    <span class="form-text
                                            text-muted">Accepted
                                        formats: gif, png, jpg. Max file size
                                        2Mb
                                    </span>
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

            //add new product here
            $("#productForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    quantity: {
                        required: true
                    },

                    category_id: {
                        required: true
                    },

                    sub_category_id: {
                        required: true
                    },

                    unit_price: {
                        required: true
                    },
                    cost_price_per_unit: {
                        required: true
                    },
                    is_active: {
                        required: true
                    }
                }, //rules end here
                messages: {
                    name: {
                        required: "please enter product name",
                        minlength: "Name must have at least 3 characters"
                    },
                    quantity: {
                        required: "quantity is required"
                    },

                    category_id: {
                        required: "select a category"
                    },

                    sub_category_id: {
                        required: "select a sub-category"
                    },

                    unit_price: {
                        required: "enter the unit price"
                    },
                    cost_price_per_unit: {
                        required: "enter the cost per unit price"
                    },
                    is_active: {
                        required: "select the status"
                    }


                }, // messages end here
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

                        url:"{{ route('product.store') }}",
                        type:"POST",
                        data:new FormData(form),
                        processData: false,
                        contentType: false,
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        },
                        success:function(response){
                            if(response.success){
                                 toastr.success(response.message, "success");
                                $("#js-product-modal").modal('hide');
                                $("#js-product-table-body").html('');
                                $("#js-product-table-body").html(response.html);
                                $("#productForm")[0].reset();
                                $(".form-control").removeClass("is-valid");
                            }
                            else{
                                 toastr.error(response.message, "error");
                            }
                        }



                    }); // ajax ends here
                } //submit handler ends here





            }); //product form validation ends

            //Edit starts here

            $(document).on('click','#js-edit-product-button', function(){
                event.preventDefault();
                var id=$(this).data('id');
                var href= "{{ route('product.edit',':id') }}".replace(':id',id);
                getDynamicDropdownData("{{ route('get.categories') }}","#js-category-dropdown");
                    $.ajax({
                    url:href,
                    type:"GET",
                    beforeSend:function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success:function(response){
                        if(response.success){
                            $("#js-product-id").val(response.data.id);
                            $("#js-product-name").val(response.data.name);
                            $("#js-product-quantity").val(response.data.quantity);
                            $("#js-unit-price").val(response.data.unit_price);
                            $("#js-cost-per-unit-price").val(response.data.cost_price_per_unit);
                            // $("#js-product-images").attr('.Images/'.response.data.images);

                            $("#js-is-active").val(response.data.is_active);
                            $("#js-category-dropdown").val(response.data.category_id).trigger("change");
                            setTimeout(() => {
                                $("#js-sub_category-dropdown")
                                    .val(response.data.sub_category_id)
                                    .trigger("change");
                            }, 500);

                 $("#js-modal-title").text("Edit Product");
                            $("#js-product-modal").modal('show');
                        }
                        else{
                             toastr.error(response.message, "error");
                        }
                    }
                });
                return false;
            });
            //edit ends here

            //delete starts here

            $(document).on('click','#js-delete-product-button', function(){
                event.preventDefault();
                var id = $(this).data("id");

                 Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this product!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result)=>{
                    if(result.isConfirmed){
                        var href="{{ route('product.destroy',':id') }}".replace(':id',id);
                        $.ajax({
                            url:href,
                            type:"DELETE",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                            },
                             success: function(response) {
                                console.log(response);
                                if(response.success){
                                    toastr.success(response.message, "success");
                                    $("#js-product-table-body").html('');
                                    $("#js-product-table-body").html(response.html);
                                }
                                else{
                                    toastr.error(response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                toastr.error("An error occurred while deleting the sub-category.", "error");
                            }
                        })
                    }
                })
            })



            //category and sub_category drop down
            $("#js-add-product-button").click(function() {

                $("#productForm")[0].reset();
                $("#js-modal-title").text("Add Product title");

                $("#js-category-dropdown").html('<option value="" selected disabled>Select Category</option>');
                $("#js-sub_category-dropdown").html('<option value="" selected disabled>Select Sub-Category</option>');

                getDynamicDropdownData("{{ route('get.categories') }}", "#js-category-dropdown");
                $("#js-product-id").val("");
                $("#js-category-dropdown").trigger('change');
                $(".form-control").removeClass("is-valid is-invalid");
                $("#js-product-modal").modal('show');
            });

            $("#js-category-dropdown").change(function() {
                let category_id = $(this).val();
                if (!category_id) return;

                    getDynamicDropdownData("{{ route('get.sub-categories') }}?category_id=" + category_id,
                        "#js-sub_category-dropdown");

            });






        }); //main function closing
    </script>
@endsection
