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
         <h5 class="card-title">Services</h5>

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
                <tbody>
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

								<form action="#">
									<div class="modal-body">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label>First name</label>
													<input type="text" placeholder="Eugene" class="form-control">
												</div>

												<div class="col-sm-6">
													<label>Last name</label>
													<input type="text" placeholder="Kopyov" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label>Address line 1</label>
													<input type="text" placeholder="Ring street 12" class="form-control">
												</div>

												<div class="col-sm-6">
													<label>Address line 2</label>
													<input type="text" placeholder="building D, flat #67" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>City</label>
													<input type="text" placeholder="Munich" class="form-control">
												</div>

												<div class="col-sm-4">
													<label>State/Province</label>
													<input type="text" placeholder="Bayern" class="form-control">
												</div>

												<div class="col-sm-4">
													<label>ZIP code</label>
													<input type="text" placeholder="1031" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label>Email</label>
													<input type="text" placeholder="eugene@kopyov.com" class="form-control">
													<span class="help-block">name@domain.com</span>
												</div>

												<div class="col-sm-6">
													<label>Phone #</label>
													<input type="text" placeholder="+99-99-9999-9999" data-mask="+99-99-9999-9999" class="form-control">
													<span class="help-block">+99-99-9999-9999</span>
												</div>
											</div>
										</div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Submit form</button>
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

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('../global_assets/js/demo_pages/datatables_basic.js') }}"></script>

@endsection
