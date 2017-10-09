<<<<<<< HEAD

     <script type="text/javascript">
=======
@extends('master')

@section('script')
    <script type="text/javascript">
>>>>>>> master
        //Ajax
        $(document).ready(function () {
           
            $(".editBtn").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

<<<<<<< HEAD
                    $("#editModal [name='drink_id']").val(d.id);
                    $("#editModal [name='name']").val(d.name);
                    $("#editModal [name='cost']").val(d.cost);
                    $("#editModal [name='num_of_materials']").val(d.num_of_materials);
=======
                    $("#editModal [name='c_id']").val(d.id);
                    $("#editModal [name='cost']").val(d.cost);
                    $("#editModal [name='name']").val(d.name);
                    
>>>>>>> master
                    
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

<<<<<<< HEAD
                    $("#delModal [name='drink_id']").val(d.id);
                    $("#delModal [name='name']").val(d.name);
                    $("#delModal [name='contact']").val(d.contact_info);
=======
                    $("#delModal [name='c_id']").val(d.id);
>>>>>>> master
                    
                    $("#delModal").modal('show');
                }
                catch(err){
                    alert(err);
                }
            });

            

        });//end ready

    </script> 
<<<<<<< HEAD


=======
@endsection

@section('content')
>>>>>>> master

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">{!! $page_title !!}</h4> </div>
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
<<<<<<< HEAD
                                    <h5 class="text-muted vb">Total Number of Drink</h5> </div>
=======
                                    <h5 class="text-muted vb">Total Number of Drinks</h5> </div>
>>>>>>> master
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-danger">{{ count(App\Site::get_records('drinks')) }}</h3> </div>
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
                </div>                
                <!-- /.row -->
                <!--row -->
                <div class="row">
                    <div class="col-sm-12">

                        @if(isset($_SESSION['notification']))

                            {!! $_SESSION['notification'] !!}

                            @php unset($_SESSION['notification']) @endphp

                        @endif
                        <div class="white-box">
                                                      
                            <a class="btn btn-default" data-toggle="modal" href="#addModal">+ Add New Drink</a>
                            <br>                           
                            <br> 

                            <div class="table-responsive">
<<<<<<< HEAD
                                <table class="table" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>DRINK ID</th>
                                            <th>COST</th>
                                            <th>NUM OF MATERIALS</th>
=======
                                <table class="table table-borderedb" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>DRINK CODE</th>
                                            <th>COST</th>
>>>>>>> master
                                            <th>DATE CREATED</th>
                                            <th>CREATED BY</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count(App\Site::get_records('drinks')) > 0)
                                           @foreach (App\Site::get_records('drinks') as $r)
                                                <tr>
<<<<<<< HEAD
                                                    <td>{{$r->name}}</td>
                                                    <td>{{ $r->uq_id }}</td>
                                                    <td>{{ $r->cost }}</td>
                                                    <td>{{ $r->num_of_materials }}</td>
                                                    <td>{{ is_null($r->created_at) ? '' : date("Y-m-d", strtotime($r->created_at)) }}</td>
                                                    <td>{{ App\Site::get_staff_name($r->created_by) }}</td>
=======
                                                    <td>{{ $r->name }}</td>
                                                    <td>{{ $r->uq_id }}</td>
                                                    <td>{{ $r->cost }}</td>
                                                    
                                                    <td>{{ is_null($r->created_at) ? '' : date("Y-m-d", strtotime($r->created_at)) }}</td>
                                                    <td>{{ App\Site::get_record("staffs", $r->created_by)->uq_id }}</td>
>>>>>>> master
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

            <div id="addModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Drink</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
<<<<<<< HEAD
                                    <div class="col-md-12">                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Drink Name</label>
=======
                                    <div class="col-md-12">  
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Name</label>
>>>>>>> master
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Cost</label>
<<<<<<< HEAD
                                                <input type="number" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Num of Materials</label>
                                                <input type="number" name="num_of_materials" class="form-control">
=======
                                                <input type="text" name="cost" class="form-control">
>>>>>>> master
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
                            <h4 class="modal-title">Edit Drink</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
<<<<<<< HEAD
                                                <label>Drink Name</label>
=======
                                                <label>Name</label>
>>>>>>> master
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Cost</label>
<<<<<<< HEAD
                                                <input type="number" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Num of Materials</label>
                                                <input type="number" name="num_of_materials" class="form-control">
=======
                                                <input type="text" name="cost" class="form-control">
>>>>>>> master
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
<<<<<<< HEAD
                                                <input type="hidden" name="drink_id">
=======
                                                <input type="hidden" name="c_id">
>>>>>>> master
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

            <div id="delModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
<<<<<<< HEAD
                            <h4 class="modal-title">Delete Drink</h4>
=======
                            <h4 class="modal-title">Delete Machine</h4>
>>>>>>> master
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                       <p>You are about to delete a record <br><br>Are you sure of this?</p>

                                        <div class="form-group">
                                            <div class="col-sm-12">
<<<<<<< HEAD
                                                <input type="hidden" name="drink_id">
=======
                                                <input type="hidden" name="c_id">
>>>>>>> master
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
<<<<<<< HEAD
                                                <input type="submit" name="delete" value="Delete drink" class="btn btn-success">
=======
                                                <input type="submit" name="delete" value="Delete" class="btn btn-success">
>>>>>>> master
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
<<<<<<< HEAD
            </div>
=======
            </div>
@endsection
>>>>>>> master
