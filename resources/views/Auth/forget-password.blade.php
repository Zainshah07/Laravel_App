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
				<form class="login-form" id="forgotPasswordForm">
                    @csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Password recovery</h5>
								<span class="d-block text-muted">We'll send you instructions in email</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-right">
								<input type="email" name="email" class="form-control" placeholder="Your email">
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

    $('#forgotPasswordForm').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {  // ✅ Correct key
                required: "Email is required",
                email: "Enter a valid email"
            }
        },
        errorElement: 'small',
        errorClass: 'text-danger',
        errorPlacement: function (error, element) {  // ✅ Correct order
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid'); // ✅ Correct class
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        invalidHandler: function (event, validator) {
            if (validator.numberOfInvalids()) {
                toastr.error("Please correct the highlighted errors before submitting.");
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: '/forgot-password',  // must match POST route
                type: 'POST',
                data: $(form).serialize(), // ✅ Correctly serialize form
                success: function (response) {
                    toastr.success(response.message);
                    $('#forgotPasswordForm')[0].reset(); // ✅ reset form after success
                },
                error: function (xhr) {
                    if (xhr.responseJSON?.message) {
                        toastr.error(xhr.responseJSON.message);
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
