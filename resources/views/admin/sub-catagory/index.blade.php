@extends('admin.layout.index');
@section('css')
@endsection
@section('page')
    Sub-Category
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
         <h5 class="card-title">Sub-Category</h5>

            <button class="btn bg-primary" data-toggle="modal" data-target="#modal_form_vertical">Create</button>
	   </div>
        <div class="panel panel-flat">
            <table class=" table datatable-basic" id="subCategoryTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>User_Id</th>
                        <th>Category_Id</th>
                        <th>Is_Active</th>


                    </tr>
                </thead>
                <tbody >
                    @foreach ($sub_categories as $sub_category)
                        <tr>
                            <td>{{ $sub_category->name }}</td>
                            <td>{{ $sub_category->slug }}</td>
                            <td>{{ $sub_category->user_id }}</td>
                            <td>{{ $sub_category->category_id }}</td>
                            <td><span class="label label-success">{{ $sub_category->is_active }}</span></td>
                        </tr>
                    @endforeach
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

								<form action="" id="subCategoryForm">
									<div class="modal-body">
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label>Name</label>
													<input type="text" placeholder="Enter the sub category" name="name" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label>Choose Category</label>
                                                     <div>
													<select class="form-control" name="category_id">
                                                           <option selected disabled> Select Category </option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>

                                                </div>
												</div>

												<div class="col-sm-6">
													<label>Is Active</label>
													<select name="is_active" id="is_active" class="form-control">
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

        $(document).ready(function(){

            $('#subCategoryForm').validate({
                rules:{
                    name:{
                        required:true,
                        minlength:3
                    },
                    category_id:{
                        required:true
                    },
                    is_active:{
                        required:true
                    }

                },

                messages:{
                    name:{
                        required:'Sub category name required',
                        minlength:'name must have atleast 3 characters'
                    },
                    category_id:{
                        required:'must choose a category'
                    },
                    is_active:{
                        required:'select the status'
                    }

                },

                errorElement:'small',
                errorClass:'text-danger',
                errorPlacement:function(error,element){
                    error.insertAfter(element);
                },
                highlight:function(element){
                    $(element).addClass('is-invalid');
                },
                unhighlight:function(element){
                    $(element).removeClass('is-invalid');
                },
                 invalidHandler:function(event, validator){
                        if (validator.numberOfInvalids()) {
                            toastr.error("Please correct the highlighted errors before submitting.");
                        }
                },

                submitHandler:function(form){
                    $.ajax({
                        $url: "{{ route('sub-category.store') }}",
                        type:"POST",
                        data:$(form).serialize(),
                        success:function(response){
                            toastr.success(response.messaage,"success");
                            $("#modal_form_vertical").modal('hide');
                            $("#")
                        }
                    });

                }
            })

        });


    </script>

@endsection
