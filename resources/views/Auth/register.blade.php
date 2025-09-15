<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration Form</title>
    <!-- Global stylesheets -->
    @include('Auth.partials.css')
    <!-- /global stylesheets -->
</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Registration form -->
                <form class="flex-fill" id="registration-form" >
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <i
                                            class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
                                        <h5 class="mb-0">Create account</h5>
                                        <span class="d-block text-muted">All fields are required</span>
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-right">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Add user name">
                                        <div class="form-control-feedback">
                                            <i class="icon-user-plus text-muted"></i>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-group-feedback form-group-feedback-right">
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Your email">
                                                <div class="form-control-feedback">
                                                    <i class="icon-mention text-muted"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-feedback form-group-feedback-right">
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Create password">
                                                <div class="form-control-feedback">
                                                    <i class="icon-user-lock text-muted"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-group-feedback form-group-feedback-right">
                                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                                    placeholder="Repeat password">
                                                <div class="form-control-feedback">
                                                    <i class="icon-user-lock text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right"><b><i
                                                class="icon-plus3"></i></b> Create account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /registration form -->

            </div>
            <!-- /content area -->


        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    {{-- -------Jquery-------- --}}
  <!-- ✅ jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ jQuery Validation AFTER jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- ✅ Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- JS files--->

    <script src="{{asset("../global_assets/js/main/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("../global_assets/js/plugins/loaders/blockui.min.js")}}"></script>

    {{------- Theme JS Files ----}}
<script src="{{asset("../global_assets/js/plugins/forms/styling/uniform.min.js")}}"></script>
<script src="{{asset("admin/assets/js/app.js")}}"></script>

    <script>
$(document).ready(function () {

     // ✅ Custom rule for password strength
    $.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element)
            || /[0-9]/.test(value)    // must contain number
            && /[!@#$%^&*(),.?":{}|<>]/.test(value); // must contain special char
    }, "Password must contain at least one number and one special character.");

  $("#registration-form").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6,
        strongPassword:true
      },
      password_confirmation: {
        required: true,
        equalTo: "[name='password']" // match password field
      }
    },
    messages: {
      name: {
        required: "Please enter your name",
        minlength: "Name must be at least 3 characters"
      },
      email: {
        required: "Please enter your email",
        email: "Enter a valid email address"
      },
      password: {
        required: "Please enter a password",
        minlength: "Password must be at least 6 characters"
      },
      password_confirmation: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match"
      }
    },
     errorElement: "small", // ✅ error will be shown in <small>
        errorClass: "text-danger", // Bootstrap style red text
        errorPlacement: function(error, element) {
            error.insertAfter(element); // ✅ show error below input
        },
        highlight: function(element) {
            $(element).addClass("is-invalid"); // Add red border
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid"); // Remove red border
        },
        invalidHandler:function(event, validator){
             if (validator.numberOfInvalids()) {
                toastr.error("Please correct the highlighted errors before submitting.");
            }
        },
    submitHandler: function (form) {

        $.ajax({
            url:"{{ route('register.action') }}",
            type:"Post",
            data:$(form).serialize(),
            success:function(){
                toastr.success("successfully added user");
                form.reset();
                $(".is_invalid").removeClass("is_invalid");
            },
            error:function(xhr){
                if (xhr.status === 422) {
                        // Laravel validation errors
                        const errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    } else {
                        toastr.error("Something went wrong!");
                    }
            }
        });
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








</body>

</html>
