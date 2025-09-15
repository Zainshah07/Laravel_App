@extends('admin.layout.index')
@section('page')
    Profile
@endsection
@section('css')
@endsection
@section('header-content')
    <div class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="navbar-collapse collapse" id="navbar-second">
            <ul class="nav navbar-nav">

                <li class="nav-item">
                    <a href="#accountInfo" class="navbar-nav-link" data-toggle="tab">
                        <i class="icon-calendar3 mr-2"></i>
                        Account Info
                        <span class="badge badge-pill bg-success position-static ml-auto ml-lg-2">32</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#passwordInfo" class="navbar-nav-link" data-toggle="tab">
                        <i class="icon-cog3 mr-2"></i>
                        Password Info
                    </a>
                </li>
            </ul>


        </div>
    </div>
@endsection
@section('content')
    <div class="d-flex align-items-start flex-column flex-md-row">

        <div
            class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-300 border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">

            <div class="sidebar-content">
                <!-- User card -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img id="profilePreview" class="img-fluid rounded-circle"
                                src="{{ auth()->user()->profile_image }}" width="170" height="170" alt="">
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                {{-- <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
												<i class="icon-plus3"></i>
											</a>
											<a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
												<i class="icon-link"></i>
											</a> --}}
                            </div>
                        </div>

                        <h6 class="font-weight-semibold mb-0">{{ auth()->user()->name }}</h6>
                        <span class="d-block text-muted">UX/UI designer</span>


                    </div>
                </div>
                <!-- /user card -->
            </div>

        </div>

        <div class="tab-content w-100 overflow-auto order-2 order-md-1">
            <div class="tab-pane active " id="accountInfo">
                <!-- Profile info -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Profile information</h5>

                    </div>


                    <div class="card-body">
                        <form id="updateProfileForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Username</label>
                                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="text" name="email" readonly="readonly"
                                            value="{{ auth()->user()->email }}" class="form-control">
                                    </div>

                                </div>
                            </div>



                            {{-- <div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Address line 1</label>
													<input type="text" value="Ring street 12" class="form-control">
												</div>
												<div class="col-md-6">
													<label>Address line 2</label>
													<input type="text" value="building D, flat #67" class="form-control">
												</div>
											</div>
										</div> --}}

                            {{-- <div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<label>City</label>
													<input type="text" value="Munich" class="form-control">
												</div>
												<div class="col-md-4">
													<label>State/Province</label>
													<input type="text" value="Bayern" class="form-control">
												</div>
												<div class="col-md-4">
													<label>ZIP code</label>
													<input type="text" value="1031" class="form-control">
												</div>
											</div>
										</div> --}}

                            <div class="form-group">
                                <div class="row">

                                    {{-- <div class="col-md-6">
						                            <label>Your country</label>
						                            <select class="form-control form-control-select2" data-fouc>
						                                <option value="germany" selected>Germany</option>
						                                <option value="france">France</option>
						                                <option value="spain">Spain</option>
						                                <option value="netherlands">Netherlands</option>
						                                <option value="other">...</option>
						                                <option value="uk">United Kingdom</option>
						                            </select>
												</div> --}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone </label>
                                        <input type="text" name="phone" value="{{ auth()->user()->phone }}"
                                            class="form-control">
                                        <span class="form-text text-muted">+99-99-9999-9999</span>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Upload profile image</label>
                                        <input type="file" accept="image/*" name="profile_image" class="form-input-styled">



                                        <span
                                            class="form-text
                                            text-muted">Accepted
                                            formats: gif, png, jpg. Max file size
                                            2Mb</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button id="js-profile-update" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /profile info -->
            </div>
            <div class="tab-pane fade" id="passwordInfo">
                <!-- Account settings -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Account settings</h5>

                    </div>

                    <div class="card-body">
                        <form id="updatePasswordForm">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Username</label>
                                        <input type="text" value="{{ auth()->user()->name }}" readonly="readonly"
                                            class="form-control">
                                    </div>


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>New password</label>
                                        <input type="password" name="password" placeholder="Enter new password"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Repeat password</label>
                                        <input type="password" name="password_confirmation"
                                            placeholder="Repeat new password" class="form-control">
                                    </div>
                                </div>
                            </div>



                            <div class="text-right">
                                <button class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- /account settings -->

            </div>

        </div>


    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            console.log('hello from jquery')
            $('#updateProfileForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength:3
                    },
                    phone:{
                        minlength:15
                    }

                },
                messages: {
                    name: {
                        required: "Name is required frontend",
                        minlength:'required 3 characters atleast'
                    },
                    phone:{
                        minlength:'at least 15 characters'
                    }

                },
                errorElement: 'small',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    event.preventDefault(); // ✅ Stop page reload completely
                    let formData = new FormData(form);
                    $.ajax({
                        url: "{{ route('profile.update') }}",
                        type: "POST",
                        data: formData,
                        processData: false, // Required for file upload
                        contentType: false, // Required for file upload

                        success: function(response) {
                            toastr.success(response.message);
                            if (response.profile_image_url) {
                                $('#profilePreview').attr('src', response
                                    .profile_image_url);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                for (let key in errors) {
                                    toastr.error(errors[key][0]);
                                }
                            } else {
                                toastr.error("Something went wrong!");
                            }
                        }

                    });
                    return false;
                }
            });
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
        });
    </script>
    <script>
        $(document).ready(function() {
            console.log('password form jquery working')
            $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) ||
                    /[0-9]/.test(value) // must contain number
                    &&
                    /[!@#$%^&*(),.?":{}|<>]/.test(value); // must contain special char
            }, "Password must contain at least one number and one special character.");

            $('#updatePasswordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                        strongPassword: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: 'input[name="password"]'
                    }
                },
                messages: {
                    password: {
                        message: "password required frontend",
                        minlength: "must contain 6 characters frontend"
                    },
                    password_confirmation: {
                        message: "field required",
                        equalTo: "password doesnt match"
                    }

                },
                errorElement: 'small',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    let formData = $(form).serialize();
                    $.ajax({
                        url: "{{ route('profile.password.update') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            toastr.success(response.message);
                            $('#updatePasswordForm')[0].reset(); // clear form
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                for (let key in errors) {
                                    toastr.error(errors[key][0]);
                                }
                            } else {
                                toastr.error("Something went wrong!");
                            }
                        }
                    });
                    return false; // prevent page reload
                }
            });
        });
    </script>
@endsection
