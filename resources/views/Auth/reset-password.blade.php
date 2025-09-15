
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    @include('Auth.partials.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>

   <div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Password recovery form -->
				<form class="login-form" id="resetPasswordForm">
                    @csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Reset Password</h5>
								<span class="d-block text-muted">Enter your new pasword</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-right">
								<input type="hidden" name="email" class="form-control" value="{{ request('email') }}" placeholder="">
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>
                            <div class="form-group form-group-feedback form-group-feedback-right">
								<input type="hidden" name="token" class="form-control" value="{{ request('token') }}" placeholder="">
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>
                             <div class="form-group form-group-feedback form-group-feedback-right">
								<input type="password" name="password" class="form-control"  placeholder="Enter new Password">
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>
                            {{-- Always use the name password_confirmation else won't work --}}

                             <div class="form-group form-group-feedback form-group-feedback-right">
								<input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm new Password">
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>

							<button type="submit" class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> Reset password</button>
						</div>
					</div>
				</form>
				<!-- /password recovery form -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ jQuery Validation AFTER jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- ✅ Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function () {
  

    // ✅ Custom password strength rule
    $.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element) ||
            (/[0-9]/.test(value) && /[!@#$%^&*(),.?":{}|<>]/.test(value));
    }, "Password must contain at least one number and one special character.");

    // ✅ Corrected selector ('#resetPasswordForm', not 'resetPasswordForm')
    $('#resetPasswordForm').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                strongPassword: true
            },
            password_confirmation: {
                required: true,
                equalTo: "[name='password']"  // ✅ fixed selector
            }
        },
        messages: {
            password: {
                required: "Password is required",
                minlength: "Password must be at least 6 characters"
            },
            password_confirmation: {
                required: "Password confirmation is required",
                equalTo: "Passwords do not match"
            }
        },
        errorElement: 'small',
        errorClass: 'text-danger',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        invalidHandler: function (event, validator) {
            if (validator.numberOfInvalids()) {
                toastr.error("Please correct the highlighted errors before submitting.");
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: '/reset-password',  // ✅ must match POST route
                type: 'POST',
                data: $(form).serialize(), // ✅ use form reference, not $(this)
                success: function (response) {
                    toastr.success(response.message);
                    setTimeout(() => window.location.href = '/login', 2000);
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong!');
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
