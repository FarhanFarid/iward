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
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
				display: flex;
				flex-direction: column;
			}
			.content-wrapper {
				flex-grow: 1; /* Ensures it takes up available space */
				display: flex;
				align-items: center;
				justify-content: center;
			}
			.row {
				display: flex;
				flex-wrap: wrap;
				justify-content: center;
				align-items: center;
			}
			.card {
				max-height: 90vh; /* Ensures it doesn't exceed the screen */
				overflow: hidden; /* Prevents internal scrolling */
			}
		</style>
		@stack('css')
	</head>
	{{-- <body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center" style="background-image: url('{{ asset('media/logo/ward-image.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-opac;"> --}}
    {{-- <body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center" style="background: rgba(0, 0, 0, 0.5) url('{{ asset('media/logo/ward-image.jpg') }}') no-repeat center center / cover; background-blend-mode: darken;">
        @yield('content')
	</body> --}}
    <body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center" style="background-color: #f5f5f5;">     
        @yield('content')

		<script>
			function checkFullscreen() {
				if (window.innerHeight === screen.height) {
					document.body.style.overflow = "hidden";
				} else {
					document.body.style.overflow = "auto";
				}
			}
			window.addEventListener("resize", checkFullscreen);
		</script>
		<script src="{{ asset('theme/assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('theme/assets/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
		<script src="{{ asset('theme/assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom/utilities/modals/create-app.js') }}"></script>
		<script src="{{ asset('theme/assets/js/custom/utilities/modals/users-search.js') }}"></script>
		<script src="{{ asset('theme/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>        
		<script src="{{ asset('js/custm.js') }}"></script>
		@stack('script')
    </body>
    
</html>