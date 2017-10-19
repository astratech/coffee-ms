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
                    $("#editModal [name='product_list_id']").val(d.product_list_id);
                    $("#editModal [name='supplier_id']").val(d.supplier_id);
                    $("#editModal [name='unit']").val(d.unit);
                    $("#editModal [name='cost']").val(d.cost);
                    $("#editModal [name='price_per_qty']").val(d.price_per_qty);
                    $("#editModal [name='quantity']").val(d.quantity);
                    
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
                <!-- row -->
                <div class="row">
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                    <h5 class="text-muted vb">Total Products in Store</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-danger">{{ count(App\Site::get_records('products')) }}</h3> </div>
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
                                                      
                            <a class="btn btn-default" data-toggle="modal" href="#addModal">+ Add New Record</a>
                            <br>                           
                            <br> 

                            <div class="table-responsive">
                                <table class="table table-bordered" id="cs-data-table">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT CODE</th>
                                            <th>PRODUCT NAME</th>
                                            <th>SUPPLIER</th>
                                            <th>QUANTITY PURCHASED</th>
                                            <th>QUANTITY AVAILABLE</th>
                                            <th>PRICE PER QUANTITY</th>
                                            <th>PURCHASED COST</th>
                                            <th>DATE CREATED</th>
                                            <th>CREATED BY</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count(App\Site::get_records('products')) > 0)
                                           @foreach (App\Site::get_records('products') as $r)
                                                <tr>
                                                    <td>{{ $r->uq_id }}</td>
                                                    <td>{{ App\Site::get_record("product_list", $r->product_list_id)->name }}</td>
                                                    <td>{{ App\Site::get_record("suppliers", $r->supplier_id)->uq_id }} - {{ App\Site::get_record("suppliers", $r->supplier_id)->name }}</td>
                                                    
                                                    <td> {{ $r->quantity }} {{ App\Site::get_record("product_list", $r->product_list_id)->unit }}</td>
                                                    <td> {{ $r->quantity }} {{ App\Site::get_record("product_list", $r->product_list_id)->unit }}</td>
                                                    <td>{{ $r->price_per_qty }} {{ App\Site::get_settings("currency")->value }}</td>
                                                    <td>{{ $r->cost }} {{ App\Site::get_settings("currency")->value }}</td>
                                                    
                                                    <td>{{ is_null($r->created_at) ? '' : date("Y-m-d", strtotime($r->created_at)) }}</td>
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
                            <h4 class="modal-title">Add Raw Product</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-Product" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">  
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Product</label>
                                                <select name="product_list_id" class="form-control">
                                                    @foreach (App\Site::get_records('product_list') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }} - {{ $r->unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Quantity </label>
                                                <input type="text" name="quantity" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Purchase Cost ({{ App\Site::get_settings("currency")->value }})</label>
                                                <input type="text" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Price Per Quantity ({{ App\Site::get_settings("currency")->value }})</label>
                                                <input type="text" name="price_per_qty" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Supplier</label>
                                                <select name="supplier_id" class="form-control">
                                                    @foreach (App\Site::get_records('suppliers') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }} - {{ $r->uq_id }}</option>
                                                    @endforeach
                                                </select>
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
                            <h4 class="modal-title">Edit Product</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-Product" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Product</label>
                                                <select name="product_list_id" class="form-control">
                                                    @foreach (App\Site::get_records('product_list') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }} - {{ $r->unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Quantity </label>
                                                <input type="text" name="quantity" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Purchase Cost ({{ App\Site::get_settings("currency")->value }})</label>
                                                <input type="text" name="cost" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Price Per Quantity ({{ App\Site::get_settings("currency")->value }})</label>
                                                <input type="text" name="price_per_qty" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Supplier</label>
                                                <select name="supplier_id" class="form-control">
                                                    @foreach (App\Site::get_records('suppliers') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }} - {{ $r->uq_id }}</option>
                                                    @endforeach
                                                </select>
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