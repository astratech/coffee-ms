<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="www.astratech.com.ng">
    <meta name="author" content="Astratech NG">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

     
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-3.2.1/jq-3.2.1/dt-1.10.16/b-1.4.2/b-html5-1.4.2/b-print-1.4.2/kt-2.3.2/r-2.2.0/rr-1.2.3/sl-1.2.3/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('site/js/site.js') }}"></script>

    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
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
    


    <script type="text/javascript">
        //Ajax
        $(document).ready(function () {
           
            $(".editBtn").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#editModal [name='staff_id']").val(d.id);
                    $("#editModal [name='name']").val(d.name);
                    $("#editModal [name='dept']").val(d.dept);
                    $("#editModal [name='email']").val(d.email);
                    $("#editModal .modal-title").text("Edit Staff: "+d.uq_id);
                    
                    $("#editModal").modal('show');
                }
                catch(err){
                    alert(err);
                }
            });

            $(".dltBtn").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#appModal [name='staff_id']").val(d.id);
                    $("#appModal .modal-title").text("Delete Staff: "+d.uq_id);
                    
                    $("#appModal").modal('show');
                }
                catch(err){
                    alert(err);
                }
            });

            $(".change-password").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#passModal [name='staff_id']").val(d.id);    
                    $("#passModal .modal-title").text("Change Staff Password: "+d.uq_id);                
                    
                    $("#passModal").modal('show');
                }
                catch(err){
                    alert(err);
                }
            });

        });//end ready
    </script> 
    
</head>

<body>
    <!-- Preloader -->
    
    
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <div class="top-left-part"><a class="logo" href="index.html"><b><img src="{{ URL::asset('site/plugins/images/logo.png') }}" alt="" style="width: 45px;" /></b><span class="hidden-xs">Coffee-MS</span></a></div>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                    	<button type='submit' name='logout' form='form-logout' class="btn btn-primary" style="margin-top: 10px; margin-right: 30px;"><span class="hide-menu"><i class="fa fa-sign-out"></i> Logout</span></button>
                    	<form action='{{ url()->current() }}' method='POST' id='form-logout'>
                    		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    	</form>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li style="padding: 10px 0 0;">
                        <a href="staffs" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="hide-menu">Staffs</span></a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Staff List</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <!--  -->
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                    <h5 class="text-muted vb">Total Number of Staffs</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-danger">{{ count(App\Site::get_records('staffs')) }}</h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                    
                                        
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> 
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.col -->
                </div>                <!-- /.row -->
                <!--row -->
                <div class="row">
                    <div class="col-sm-12">

                        @if(isset($_SESSION['notification']))

                            {!! $_SESSION['notification'] !!}

                            @php unset($_SESSION['notification']) @endphp

                        @endif
                        <div class="white-box">
                                                      
                            <a class="btn btn-default" data-toggle="modal" href="#addModal">+ Add New Staff</a>
                            <br>                           
                            <br> 

                            <div class="table-responsive">
                                <table class="table" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>STAFF ID</th>
                                            <th>DEPARTMENT</th>
                                            <th>EMAIL</th>
                                            <th>PASSWORD</th>
                                            <th>LAST LOGIN</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count(DB::select("SELECT * FROM staffs")) > 0)
                                           @foreach (DB::select("SELECT * FROM staffs") as $r)
                                                <tr>
                                                    <td>{{$r->name}}</td>
                                                    <td>{{ $r->uq_id }}</td>
                                                    <td>{{ $r->dept }}</td>
                                                    <td>{{ $r->email }}</td>
                                                    <td>
                                                    	<p>{{ App\Site::decode_password($r->password) }}</p>
                                                    	<button class="btn btn-info btn-xs change-password" data-all="{{ (json_encode($r)) }}">Change Password</button>
                                                    </td>
                                                    <td>{{ is_null($r->last_login) ? '' : date("Y-m-d", strtotime($r->last_login)) }}</td>
                                                    <td>
                                                        <button class="btn btn-default btn-sm editBtn" data-all="{{ (json_encode($r)) }}">Edit</button>
                                                        <button class="btn btn-danger btn-sm dltBtn" data-all="{{ (json_encode($r)) }}">Delete</button>
                                                    </td>
                                                </tr>
                                           @endforeach
                                        @endif
                                    </tbody>
                                </table> 

                                </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Coffee-Ms </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->


    <div id="addModal" class="modal fade" role="dialog">
     	<div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            	<h4 class="modal-title">Add Staff</h4>
	        	</div>
	        	
	            <div class="modal-body">
	                <div class="row">
	                	<form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
		            		{{ csrf_field() }}
		                    <div class="col-md-12">                        
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Staff Name</label>
		                                <input type="text" name="name" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Department</label>
		                                <input type="text" name="dept" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Email</label>
		                                <input type="text" name="email" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Password</label>
		                                <input type="text" name="password" class="form-control" value="{{ App\Site::gen_token() }}" readonly>
		                            </div>
		                        </div>

		                        <div class="form-group">
		                   			<div class="col-sm-12">
				                        <input type="submit" name="create" value="Submit" class="btn btn-success">
				                    </div>
				                </div>
		            		</div>
						</form>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        	
	        </div>

		</div>
	</div>

	<div id="editModal" class="modal fade" role="dialog">
     	<div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            	<h4 class="modal-title">Edit Staff</h4>
	        	</div>
	        	
	            <div class="modal-body">
	                <div class="row">
	                	<form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
		                    <div class="col-md-12">                        
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Staff Name</label>
		                                <input type="text" name="name" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Department</label>
		                                <input type="text" name="dept" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Email</label>
		                                <input type="text" name="email" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <input type="hidden" name="staff_id">
		                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                   			<div class="col-sm-12">
				                        <input type="submit" name="update" value="Update Details" class="btn btn-success">
				                    </div>
				                </div>
		            		</div>
						</form>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        	
	        </div>

		</div>
	</div>

	<div id="passModal" class="modal fade" role="dialog">
     	<div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            	<h4 class="modal-title">Change Staff Password</h4>
	        	</div>
	        	
	            <div class="modal-body">
	                <div class="row">
	                	<form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
		                    <div class="col-md-12">                        

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>New Password</label>
		                                <input type="password" name="password" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <label>Retype New Password</label>
		                                <input type="password" name="rpassword" class="form-control">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <input type="hidden" name="staff_id">
		                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                   			<div class="col-sm-12">
				                        <input type="submit" name="update_password" value="Change Password" class="btn btn-success">
				                    </div>
				                </div>
		            		</div>
						</form>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        	
	        </div>

		</div>
	</div>

	<div id="appModal" class="modal fade" role="dialog">
     	<div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            	<h4 class="modal-title">Delete Staff</h4>
	        	</div>
	        	
	            <div class="modal-body">
	                <div class="row">
	                	<form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
		                    <div class="col-md-12">                        
		                    <p>You are about to delete a record <br><br>Are you sure of this?</p>
		                        <div class="form-group">
		                            <div class="col-sm-12">
		                                <input type="hidden" name="staff_id">
		                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                   			<div class="col-sm-12">
				                        <input type="submit" name="delete" value="Delete Staff" class="btn btn-success">
				                    </div>
				                </div>
		            		</div>
						</form>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        	
	        </div>

		</div>
	</div>

    
</body>

</html>