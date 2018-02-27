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

            $(".add-mat").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#itemModal [name='drink_id']").val(d.id);
                    
                    
                    $("#itemModal").modal('show');
                }
                catch(err){
                    alert(err);
                }
            });

            $(".remove-material").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#removeModal [name='c_id']").val(d.id);
                    
                    
                    $("#removeModal").modal('show');
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
<<<<<<< HEAD
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
                                    
=======
                @if(isset($page_type) AND $page_type == "single")

                    <!-- /.row -->
                    <!--row -->
                    <div class="row">
                        <div class="col-sm-12">

                            @if(isset($_SESSION['notification']))

                                {!! $_SESSION['notification'] !!}

                                @php unset($_SESSION['notification']) @endphp

                            @endif
                            <div class="white-box">
   

                                <div class="table-responsive">
                                    <table class="table table-borderedb" id="cs-data-table">
                                        <thead>
                                            <tr>
                                                <th>DRINK CODE</th>
                                                <th>MATERIALS TO BE USED</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count(DB::select("SELECT * FROM drinks WHERE id='$drink_id'")) > 0)
                                               @foreach (DB::select("SELECT * FROM drinks WHERE id='$drink_id'") as $r)
                                                    <tr>
                                                        <td>{{ $r->uq_id }}</td>
                                                        <td>
                                                            @if(count(DB::select("SELECT * FROM drink_products WHERE drink_id='$r->id'")) > 0)
                                                                @foreach(DB::select("SELECT * FROM drink_products WHERE drink_id='$r->id'") as $d)
                                                                   <li style="width: 100%;">{{  App\Site::get_record("product_list", $d->product_list_id)->name }} ( {{ $d->quantity }} {{  App\Site::get_record("product_list", $d->product_list_id)->unit }} ) <button class="btn btn-danger btn-xs remove-material" data-all="{{ (json_encode($d)) }}">x</button></li>
                                                                @endforeach
                                                                
                                                            @else
                                                                <p>No Product Added</p>
                                                            @endif
                                                            <p><button class="btn btn-info btn-xs add-mat" data-all="{{ (json_encode($r)) }}">+ Add Product</button></p>
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

                @else
                    <!-- row -->
                    <div class="row">
                        <!--col -->
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="white-box">
                                <div class="col-in row">
                                    <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                        <h5 class="text-muted vb">Total Number of Drinks</h5> </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h3 class="counter text-right m-t-15 text-danger">{{ count(App\Site::get_records('drinks')) }}</h3> </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="progress">
>>>>>>> master
                                        
                                            
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> 
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </div>


<<<<<<< HEAD
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
=======
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
                                    <table class="table table-borderedb" id="cs-data-table">
                                        <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>DRINK CODE</th>
                                                <th>DATE CREATED</th>
                                                <th>CREATED BY</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count(App\Site::get_records('drinks')) > 0)
                                               @foreach (App\Site::get_records('drinks') as $r)
                                                    <tr>
                                                        <td>{{ $r->name }}</td>
                                                        <td>{{ $r->uq_id }}</td>
                                                        
                                                        <td>{{ is_null($r->created_at) ? '' : date("Y-m-d", strtotime($r->created_at)) }}</td>

                                                        <td>{{ App\Site::get_record("staffs", $r->created_by)->uq_id }}</td>
                                                        <td>
                                                            <a class="btn btn-primary btn-sm" href="{{ url('/drinks') }}/{{ $r->id }}">View</a>
                                                            <button class="btn btn-default btn-sm editBtn" data-all="{{ (json_encode($r)) }}">Edit</button>
                                                            <button class="btn btn-danger btn-sm dltBtn" data-all="{{ (json_encode($r)) }}">Delete</button>
                                                            
                                                        </td>
                                                    </tr>
                                               @endforeach
                                            @endif
                                        </tbody>
                                    </table> 
>>>>>>> master

                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                @endif
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
<<<<<<< HEAD
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
=======
>>>>>>> master
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
<<<<<<< HEAD
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
=======
                                                <input type="hidden" name="c_id">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
>>>>>>> master
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
<<<<<<< HEAD
<<<<<<< HEAD
                                                <input type="hidden" name="drink_id">
=======
                                                <input type="hidden" name="c_id">
>>>>>>> master
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
=======
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

            <div id="itemModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Product</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">  
                                        

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Raw Material</label>
                                                <select name="product_list_id" class="form-control">
                                                    @foreach (App\Site::get_records('product_list') as $r)
                                                        <option value="{{ $r->id }}"> {{ $r->name }} -  ({{ $r->unit }})</option>
                                                    @endforeach
                                                </select>
>>>>>>> master
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Quantity</label>
                                                <input type="number" name="quantity" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="drink_id">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="submit" name="add_material" value="Add Material to Drink" class="btn btn-success">
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
<<<<<<< HEAD
                            <h4 class="modal-title">Delete Drink</h4>
=======
                            <h4 class="modal-title">Delete Machine</h4>
>>>>>>> master
=======
                            <h4 class="modal-title">Delete Drink</h4>
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
<<<<<<< HEAD
@endsection
>>>>>>> master
=======

            <div id="removeModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Material Record</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                       <p>You are about to delete a record <br><br>Are you sure of this?</p>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="c_id">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="submit" name="delete_material" value="Delete" class="btn btn-success">
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
@endsection
>>>>>>> master
