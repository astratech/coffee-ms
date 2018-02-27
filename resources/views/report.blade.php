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
                    $("#editModal [name='drink_id']").val(d.drink_id);
                    $("#editModal [name='rent_id']").val(d.rent_id);
                    $("#editModal [name='num_of_purchase']").val(d.num_of_purchase);
                    $("#editModal [name='date_recorded']").val(d.date_recorded);
                    
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
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h4>Sales Report for {{ $sales_uq_id }}</h4>
        
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

                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <p>Materials Used</p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Drink Name</th>
                                                <th>Products Used</th>
                                                <th>Drink Price</th>
                                                <th>Units Sold</th>
                                                <th>Sales Price</th>
                                                <th>Cost Price</th>
                                                <th>Profit</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_unit = 0;
                                                    $total_cost_price = 0;
                                                    $total_sales_price = 0;
                                                    $total_profit = 0;

                                                @endphp

                                                @if(count(DB::select("SELECT * FROM sales_entry WHERE sales_id='$sales_id'")) > 0)
                                                    @foreach(DB::select("SELECT * FROM sales_entry WHERE sales_id='$sales_id'") as $r)
                                                        <tr>
                                                            <td>{{ App\Site::get_record("drinks", $r->drink_id)->name }}</td>
                                                            <td>
                                                                @php $t_m_cost = 0; @endphp
                                                                @foreach(DB::select("SELECT * FROM drink_products WHERE drink_id='$r->drink_id'") as $i)
                                                                    @php

                                                                        $m_cost = $i->quantity * App\Site::get_record("product_list", $i->product_list_id)->price_per_qty;
                                                                        $t_m_cost = $t_m_cost + $m_cost;
                                                                        $single_cost = $t_m_cost * $r->num_of_purchase;
                                                                    @endphp
                                                                    <p>- {{ App\Site::get_record("product_list", $i->product_list_id)->name }} - ( {{ $i->quantity }} {{ App\Site::get_record("product_list", $i->product_list_id)->unit }} * {{ App\Site::get_record("product_list", $i->product_list_id)->price_per_qty }} {{ App\Site::get_settings("currency")->value }} = {{ $m_cost }} {{ App\Site::get_settings("currency")->value }})</p>
                                                                @endforeach
                                                                <p>Drink Cost Price = {{ $t_m_cost }} {{ App\Site::get_settings("currency")->value }}</p>
                                                            </td>

                                                            {{-- GET RENT DRINK COST --}}
                                                            <td>{{ App\Site::get_rent_drink_via_rd($rent_id, $r->drink_id)->cost }} {{ App\Site::get_settings("currency")->value }}</td>
                                                            <td>{{ $r->num_of_purchase }}</td>
                                                            <td>{{ $r->amount }} {{ App\Site::get_settings("currency")->value }}</td>
                                                            <td>{{ $single_cost }} {{ App\Site::get_settings("currency")->value }}</td>
                                                            @php $profit = $r->amount - $single_cost; @endphp
                                                            <td>{{ $profit }} {{ App\Site::get_settings("currency")->value }}</td>

                                                            {{-- calculate all --}}
                                                            @php
                                                                $total_unit = $r->num_of_purchase + $total_unit;
                                                                $total_cost_price = $single_cost + $total_cost_price;
                                                                $total_sales_price = $r->amount + $total_sales_price;
                                                                $total_profit = $profit + $total_profit;
                                                            @endphp
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    
                                        <div>
                                            <p>TOTAL UNITS SOLD: {{ $total_unit }}</p>
                                            <p>TOTAL COST PRICE: {{ $total_cost_price }} {{ App\Site::get_settings("currency")->value }}</p>
                                            <p>TOTAL SALES PRICE: {{ $total_sales_price }} {{ App\Site::get_settings("currency")->value }}</p>
                                            <p>TOTAL PROFIT MADE: {{ $total_profit }} {{ App\Site::get_settings("currency")->value }}</p>
                                        </div>
                                </div>

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
                            <h4 class="modal-title">Add Sales Record</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">  
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Rent</label>
                                                <select name="rent_id" class="form-control">
                                                    @foreach (App\Site::get_records('rents') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->uq_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Drink</label>
                                                <select name="drink_id" class="form-control">
                                                    @foreach (App\Site::get_records('drinks') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Number of Purchase</label>
                                                <input type="text" name="num_of_purchase" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Date Recorded</label>
                                                <input type="text" name="date_recorded" class="form-control" data-provide="datepicker">
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
                                <form class="form-horizontal form-material" method="POST" action="{{ url()->current() }}">
                                    <div class="col-md-12">                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Rent</label>
                                                <select name="rent_id" class="form-control">
                                                    @foreach (App\Site::get_records('rents') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->uq_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Select Drink</label>
                                                <select name="drink_id" class="form-control">
                                                    @foreach (App\Site::get_records('drinks') as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Number of Units Sold</label>
                                                <input type="text" name="num_of_purchase" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Date Recorded</label>
                                                <input type="text" name="date_recorded" class="form-control" data-provide="datepicker">
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
                            <h4 class="modal-title">Delete Machine</h4>
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