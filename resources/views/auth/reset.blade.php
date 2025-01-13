
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>{{ config('app.name') }} | Setel Ulang Akun</title>
		<meta name="author" content="{{ config('app.name') }}">
		<meta name="keywords" content="{{ config('app.name') }}" />
		<meta name="description" content="{{ config('app.name') }}">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/kejaksaan-logo.jpg') }}" />

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link id="googleFonts" href="{{ asset('assets/css/google_font.css') }}" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.compat.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

		<!-- Head Libs -->
		<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign body-locked">
			<div class="center-sign">
				<div class="panel card-sign">
					<div class="card-body">
                        <form action="{{ route('reset.post') }}" method="post">
                            @csrf
							<div class="current-user text-center">
								<img src="{{ asset('assets/img/logo/kejaksaan-logo.jpg') }}" alt="Webphada" class="user-image" style="background-color: white;width: 150px;padding:10px;" />
								
								@if (session()->has('alert'))
                                    <div class="alert alert-warning alert-dismissible d-flex align-items-center fade show" role="alert">
										<i class='bx bxs-info bx-flashing bx-sm me-2' style='color:#F30606'></i> {{ session()->get('alert') }}
                                        <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                                    </div>
                                @endif
								
								<h2 class="user-name text-dark m-0">Setel Ulang Akun</h2>
								<p class="user-email m-0">Silahkan masukkan Nama Akun yang akan di setel ulang</p>
							</div>
                            <div class="form-group mb-3">
								<div class="input-group">
									<input value="" id="username" type="text" class="form-control form-control-lg @if (session()->has('alert')) is-invalid @endif" name="username" value="{{ old('username') }}" placeholder="Nama Akun" autocomplete="off" required />
									<span class="input-group-text">
										<i class="bx bx-user"></i>
									</span>
								</div>
							</div>
							
							<div class="row">
								<div class="col-7"></div>
								<div class="col-5">
                                    <button type="submit" class="mb-1 mt-1 me-1 btn btn-primary pull-right">PROSES <i class="fas fa-sign-in-alt"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<p class="text-center text-muted mt-3 mb-3">&copy; Hak Cipta 2023. Kejaksaan Republik Indonesia.</p>
			</div>
		</section>
		<!-- end: page -->
        
        <!-- Vendor -->
        <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
        <script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('assets/vendor/common/common.js') }}"></script>
        <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
        <script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

		<!-- Specific Page Vendor -->

		<!-- Theme Base, Components and Settings -->
		<script src="{{ asset('assets/js/theme.js')}}"></script>

		<!-- Theme Custom -->
		
		<!-- Theme Initialization Files -->
		<script src="{{ asset('assets/js/theme.init.js')}}"></script>

		<script type="text/javascript">
			$(document).ready(function () {
				window.setTimeout(function() {
					$(".alert").fadeTo(1000, 0).slideUp(1000, function() {
						$(this).remove(); 
					});
				}, 5000);
			});
		</script>
		<script type="text/javascript">
			$("#btn-refresh").click(function(){
				$.ajax({
					type:'GET',
					url:'/refresh-captcha',
					success:function(data){
						$(".captcha span").html(data.captcha);
					}
				});
			});
			</script>
	</body>
</html>
