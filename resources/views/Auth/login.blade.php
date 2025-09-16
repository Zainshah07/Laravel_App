<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
    @include('auth.partials.css')


	<!-- /global stylesheets -->

{{-- ------JS------- --}}


</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form class="login-form" action="" id="login_form">
                    @csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Login to your account</h5>
								<span class="d-block text-muted">Your credentials</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="email" class="form-control" name="email" placeholder="enter user email">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" id="password" class="form-control" name="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group d-flex align-items-center">
								<div class="form-check mb-0">
									<label class="form-check-label">
										<input type="checkbox" name="remember" class="form-input-styled" checked>
										Remember
									</label>
								</div>

								<a href="{{ route('forgot.password') }}" class="ml-auto">Forgot password?</a>
							</div>

							<div class="form-group">
								<button class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							{{-- <div class="form-group text-center text-muted content-divider">
								<span class="px-2">or sign in with</span>
							</div> --}}

							{{-- <div class="form-group text-center">
								<button type="button" class="btn btn-outline bg-indigo border-indigo text-indigo btn-icon rounded-round border-2"><i class="icon-facebook"></i></button>
								<button type="button" class="btn btn-outline bg-pink-300 border-pink-300 text-pink-300 btn-icon rounded-round border-2 ml-2"><i class="icon-dribbble3"></i></button>
								<button type="button" class="btn btn-outline bg-slate-600 border-slate-600 text-slate-600 btn-icon rounded-round border-2 ml-2"><i class="icon-github"></i></button>
								<button type="button" class="btn btn-outline bg-info border-info text-info btn-icon rounded-round border-2 ml-2"><i class="icon-twitter"></i></button>
							</div> --}}

							<div class="form-group text-center text-muted content-divider">
								<span class="px-2">Don't have an account?</span>
							</div>

							<div class="form-group">
								<a href="{{ route('register') }}" class="btn btn-light btn-block">Sign up</a>
							</div>

							<span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
						</div>
					</div>
				</form>
				<!-- /login form -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ jQuery Validation AFTER jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- ✅ Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- @include('auth.partials.js'); --}}

<script>
    $(document).ready(function(){
        $.validator.addMethod("strongPassword", function(value,element){
            return this.optional(element)
             || /[0-9]/.test(value)    // must contain number
            && /[!@#$%^&*(),.?":{}|<>]/.test(value); // must contain special char
    }, "Password must contain at least one number and one special character.");
        $('#login_form').validate({
            rules:{
                email:{
                    required:true,
                    email:true
                },
                password:{
                    required:true,
                    minlength:6,
                    strongPassword:true
                }
            },

            messages:{
                email:{
                    required:"please enter user eamil",
                    minlength:"invalid email"
                },
                password:{
                    required:"please enter your password",
                    minlength:"enter atleast 6 characters"
                }
            },

            errorElement:'small',
            errorClass:'text-danger',
            errorPlacement:function(error, element){
                error.insertAfter(element);
            },
            highlight:function(element){
                $(element).addClass("is-invalid");
            },
            unhighlight:function(element){
                $(element).removeClass("is-invalid");
            },
            invalidHandler:function(error,validator){
                if(validator.numberOfInvalids()){
                    toastr.error("Please correct the highlighted errors before submitting.");
                }
            },

            submitHandler: function (form) {
              $.ajax({
                url:'/login-check',
                type:'POST',
                data:$(form).serialize(),
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
},
                success:function(response){
                    if(response.success){
                        toastr.success("Login successful! Redirecting...");
                        setTimeout(() => {
                            window.location.href = "{{ route('profile') }}"; // redirect after login
                        }, 1000);
                    }
                    else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error("Something went wrong. Try again.");
                }
              })
                // Or send AJAX request here
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
