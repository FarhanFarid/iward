<!DOCTYPE html>
<html lang="en">
	<head>
		<title>iWard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<link rel="shortcut icon" href="{{asset('media/logo/ijn-logo.png')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('theme/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('theme/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
		<!--end::Global Stylesheets Bundle-->
	</head>
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
            <div class="d-flex flex-column flex-column-fluid flex-lg-row">
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <div class="d-flex flex-center flex-lg-start flex-column">
                        <a href="#" class="mb-7">
                            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-5" src="{{ asset('media/logo/iward.png') }}" alt="" />
                        </a>
                        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">WELCOME TO IJN iWARD</h1>
                    </div>
                </div>
                
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); background-color: #7ad4fa54 !important;">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10">
                            <form class="form w-100">
                                @csrf
                                <div class="text-center mb-11">
                                    <img alt="Logo" src="{{asset('media/logo/ijnflagship.png')}}" style="max-height:100px; margin-bottom: 5px;" />
                                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Login With IJN's credential</div>
                                </div>
                                <div class="fv-row mb-8">
                                    <label for="email" class="form-label fw-bold text-gray-700 fs-3 mb-2">Username</label>
                                    <input type="text" name="email" autocomplete="off" class="form-control form-control-lg p-4" style="background-color: #f5f5f5; color: #6c757d; border: 1px solid #7ad4fa54;" />
                                </div>
                                <div class="fv-row mb-8">
                                    <label for="email" class="form-label fw-bold text-gray-700 fs-3 mb-2">Password</label>
                                    <input type="password" name="password" autocomplete="off" class="form-control form-control-lg p-4" style="background-color: #f5f5f5; color: #6c757d; border: 1px solid #7ad4fa54;" />
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="button" class="btn btn-primary btn-lg login">
                                        <span class="indicator-label">Sign In</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex flex-stack px-lg-10">
                            <div class="me-0">
                                <h6 class="mr-1">{{ now()->year }}&nbsp;©</h6>
                            </div>
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <h6><a href="https://www.ijn.com.my/" target="_blank" class="text-gray-800 text-hover-primary" style="color: #004990">Management Information Systems (MIS)</a></h6> 	
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        

        <script src="{{ asset('theme/assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('theme/assets/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('js/custm.js') }}"></script>
        <script>
            // global app configuration object
            var config = {
                    routes: {
                        login : "{{ route('sso.login') }}",
                        dashboard : "{{ route('dashboard.index') }}",
                }
            };
        </script>
        <script src="{{ asset('js/auth/login.js') }}"></script>
        @stack('script')
	</body>
</html>