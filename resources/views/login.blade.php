<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="www.astratech.com.ng">
	<meta name="author" content="Astratech NG">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/plugins/images/favicon.png">
	<title>Coffee-Ms</title>
	<!-- Bootstrap Core CSS -->
	<link href="{{ URL::asset('site/css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('site/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('site/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('site/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('site/css/animate.css') }}" rel="stylesheet">

	<link href="{{ URL::asset('site/css/style.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('site/css/colors/blue-dark.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-3.2.1/jq-3.2.1/dt-1.10.16/b-1.4.2/b-html5-1.4.2/b-print-1.4.2/kt-2.3.2/r-2.2.0/rr-1.2.3/sl-1.2.3/datatables.min.css"/>

	<!-- jQuery -->
	<script src="{{ URL::asset('site/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="{{ URL::asset('site/css/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Menu Plugin JavaScript -->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-color: #795548!important; min-height: 1000px;">
	<div class="container">
		<div class="row" style="margin-top: 20%;">
			<div class="col-md-6 col-md-offset-3" style="color: #444; background-color: #fff; border-radius: 3px; min-height: 300px;">
				<form action="" method="POST" class="form-horizontal form-material">
					<div class="col-md-12">
						<h3 class="text-center">Login</h3>
						<div class="form-group">
							<div class="col-md-12">
								<label>Staff Email</label>
								<input type="text" name="email" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<label>Password</label>
								<input type="password" name="password" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="submit" name="login" class="btn btn-success btn-block" value="Login">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6">
								<p>Forgot Password? Contact Admin</p>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		
	</div>


	<script src="{{ URL::asset('site/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<!--slimscroll JavaScript -->
	<script src="{{ URL::asset('site/js/jquery.slimscroll.js') }}"></script>
	<!--Wave Effects -->
	<script src="{{ URL::asset('site/js/waves.js') }}"></script>
	<!--Counter js -->
	<script src="https://cdn.jsdelivr.net/npm/jdenticon@1.7.2" async></script>
	<script src="{{ URL::asset('site/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
	<script src="{{ URL::asset('site/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
	<!--Morris JavaScript -->
	<script src="{{ URL::asset('site/plugins/bower_components/raphael/raphael-min.js') }}"></script>
	<script src="{{ URL::asset('site/plugins/bower_components/morrisjs/morris.js') }}"></script>
	<!-- Custom Theme JavaScript -->
	<!-- <script src="{{ URL::asset('site/js/custom.min.js') }}"></script> -->
	<script src="{{ URL::asset('site/js/dashboard1.js') }}"></script>

	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.2.1/jq-3.2.1/dt-1.10.16/b-1.4.2/b-html5-1.4.2/b-print-1.4.2/kt-2.3.2/r-2.2.0/rr-1.2.3/sl-1.2.3/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script> -->
	<!-- Custom Theme JavaScript -->
</body>

</html>