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
    

    @yield('script')
   
    
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
                        <form action='{{ url('/logout')}}' method='POST' id='form-logout'>
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
                        <a href="{{ url('/dashboard') }}" class="waves-effect"><span class="hide-menu">Dashboard</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/units') }}" class="waves-effect"><span class="hide-menu">Units</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/suppliers') }}" class="waves-effect"><span class="hide-menu">Suppliers</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/materials') }}" class="waves-effect"><span class="hide-menu">Materials</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/drinks') }}" class="waves-effect"><span class="hide-menu">Drinks</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/customers') }}" class="waves-effect"><span class="hide-menu">Customers</span></a>
                    </li>

                    <li style="padding: 10px 0 0;">
                        <a href="{{ url('/machines') }}" class="waves-effect"><span class="hide-menu">Machines</span></a>
                    </li>



                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->

        @yield('content')