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
                    $("#editModal [name='machine_id']").val(d.machine_id);
                    $("#editModal [name='cost']").val(d.cost);
                    $("#editModal [name='maintenance_date']").val(d.maintenance_date);
                    $("#editModal [name='note']").val(d.note);
                    
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

                <!--row -->
                <div class="row">
                    <div class="col-sm-12">

                        @if(isset($_SESSION['notification']))

                            {!! $_SESSION['notification'] !!}

                            @php unset($_SESSION['notification']) @endphp

                        @endif
                        <div class="white-box">
                                                      
                            <a class="btn btn-default" data-toggle="modal" href="#addModal">+ Add New Record</a>
                            <br>                           
                            <br> 

                            <div class="table-responsive">
                                <table class="table table-borderedb" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>MACHINE</th>
                                            <th>DATE</th>
                                            <th>COST</th>
                                            <th>NOTE</th>
                                            <th>CREATED BY</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count(App\Site::get_records('maintenance')) > 0)
                                           @foreach (App\Site::get_records('maintenance') as $r)
                                                <tr>
                                                    <td>{{ App\Site::get_record("machines", $r->machine_id)->uq_id }} <br> {{ App\Site::get_record("machines", $r->machine_id)->model }}</td>
                                                    <td>{{ $r->maintenance_date }}</td>
                                                    <td>{{ $r->cost }}</td>
                                                    <td>{{ $r->note }}</td>

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
                            <h4 class="modal-title">Create New Record</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-Product" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">  
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Machine</label>
                                                <select name="machine_id" class="form-control">
                                                    @foreach (App\Site::get_records('machines') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->uq_id }} {{ $r->model }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Cost</label>
                                                <input type="number" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Date</label>
                                                <input type="text" name="maintenance_date" class="form-control" data-provide="datepicker">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Note</label>
                                                <textarea name="note" class="form-control"></textarea>
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
                            <h4 class="modal-title">Edit Record</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-Product" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Machine</label>
                                                <select name="machine_id" class="form-control">
                                                    @foreach (App\Site::get_records('machines') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->uq_id }} {{ $r->model }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Cost</label>
                                                <input type="number" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Date</label>
                                                <input type="text" name="maintenance_date" class="form-control" data-provide="datepicker">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>Note</label>
                                                <textarea name="note" class="form-control"></textarea>
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

            <div id="delModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Product</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-Product" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                       <p>You are about to delete this record <br><br>Are you sure of this?</p>

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