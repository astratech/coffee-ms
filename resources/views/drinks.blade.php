@extends('master')

@section('script')
    <script type="text/javascript">
        //Ajax
        $(document).ready(function () {
           
            $(".editBtn").click(function (e) {
                e.preventDefault();
                try{
                    var d = $(this).data('all');

                    $("#editModal [name='c_id']").val(d.id);
                    $("#editModal [name='cost']").val(d.cost);
                    $("#editModal [name='name']").val(d.name);
                    
                    
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

                    $("#delModal [name='c_id']").val(d.id);
                    
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

            

        });//end ready

    </script> 
@endsection

@section('content')

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
                                    <h5 class="text-muted vb">Total Number of Drinks</h5> </div>
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
                                <table class="table table-borderedb" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>DRINK CODE</th>
                                            <th>COST</th>
                                            <th>DATE CREATED</th>
                                            <th>MATERIALS USED</th>
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
                                                    <td>{{ $r->cost }} {{ App\Site::get_settings("currency")->value }}</td>
                                                    
                                                    <td>{{ is_null($r->created_at) ? '' : date("Y-m-d", strtotime($r->created_at)) }}</td>

                                                    <td>
                                                        @if(count(DB::select("SELECT * FROM drink_materials WHERE drink_id='$r->id'")) > 0)
                                                            @foreach(DB::select("SELECT * FROM drink_materials WHERE drink_id='$r->id'") as $d)
                                                               <li>{{  App\Site::get_record("raw_materials", $d->material_id)->name }} - {{ $d->quantity }} {{ App\Site::get_record("raw_materials", $d->material_id)->unit }}</li>
                                                            @endforeach
                                                            
                                                        @else
                                                            <p>No Material Added</p>
                                                        @endif
                                                        <p><button class="btn btn-info btn-xs add-mat" data-all="{{ (json_encode($r)) }}">+ Add Material</button></p>
                                                    </td>
                                                    <td>{{ App\Site::get_record("staffs", $r->created_by)->uq_id }}</td>
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
                                    <div class="col-md-12">  
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Cost</label>
                                                <input type="text" name="cost" class="form-control">
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
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Cost</label>
                                                <input type="text" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="c_id">
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

            <div id="itemModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Raw Material</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">  
                                        

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Raw Material</label>
                                                <select name="material_id" class="form-control">
                                                    @foreach (App\Site::get_records('raw_materials') as $r)
                                                        <option value="{{ $r->id }}"> {{ $r->name }} - {{ $r->uq_id }} - {!! App\Site::get_material_qty_left($r->id) !!} {{ $r->unit }} Available</option>
                                                    @endforeach
                                                </select>
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
                            <h4 class="modal-title">Delete Drink</h4>
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
                                                <input type="submit" name="delete" value="Delete" class="btn btn-success">
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