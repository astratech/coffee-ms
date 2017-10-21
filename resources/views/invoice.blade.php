@extends('master');

@section('script')
    <script type="text/javascript">
        //Ajax
        $(document).ready(function () {

            $(".printNow").click(function (e) {
                e.preventDefault();
                $('.d-invoice').printThis();
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
                            <li>Welcome {{ App\Site::get_record('staffs', $_SESSION['coffee_staff_logged']['id'])->name }}</li>
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
                                    <h5 class="text-muted vb">Generated Invoice for {{ $rent_uq_id }} </h5> </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                    
                                        
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> 
                                        </div>
                                    </div>
                                    <button class="btn btn-default printNow">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- /.col -->
                </div>                
                <!-- /.row -->


                <div class="row d-invoice">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="col-in row">
                                
                                <div class="col-md-6">
                                    <img src="{{ URL::asset('site/plugins/images/logo.png') }}" alt="" style="width: 45px;" /><span style="font-size: 22px; margin-left: 10px;">Coffee-MS</span>
                                </div>

                                <div class="col-md-6">
                                    <div style="text-align: right; line-height: 1; font-size: 17px;">
                                        <p>Invoice Num: {{ $rent_uq_id }}</p>
                                        <p>To: {{  App\Site::get_record("customers", $rent_customer_id)->name }}</p>
                                        <p>P: {{  App\Site::get_record("customers", $rent_customer_id)->mobile }}</p>
                                        <p>E: {{  App\Site::get_record("customers", $rent_customer_id)->email }}</p>
                                        <p>Invoice Date: {{ date("M d, Y") }}</p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-borderedb">
                                            <thead>
                                                <tr style="text-transform: capitalize!important; font-size: 16px;">
                                                    <th>MACHINE</th>
                                                    <th>RENT PERIOD</th>
                                                    <th>RENT PRICE</th>
                                                    <th>ASSIGNED DRINKS</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 15px;">
                                               @foreach (DB::select("SELECT * FROM rents WHERE id='$rent_id'") as $r)
                                                    <tr>
                                                        <td>{{ App\Site::get_record("machines", $r->machine_id)->uq_id }} <br> {{ App\Site::get_record("machines", $r->machine_id)->model }} </td>
                                                        <td>{{ date("M d,Y", strtotime($r->date_from)) }} - {{ date("M d,Y", strtotime($r->date_to)) }}</td>
                                                        <td>{{ $r->price }} {{ App\Site::get_settings("currency")->value }}</td>

                                                        <td>
                                                            @if(count(DB::select("SELECT * FROM rent_drinks WHERE rent_id='$r->id'")) > 0)
                                                                @foreach(DB::select("SELECT * FROM rent_drinks WHERE rent_id='$r->id'") as $d)
                                                                   <p>- {{  App\Site::get_record("drinks", $d->drink_id)->name }} ({{ $d->cost }} {{ App\Site::get_settings("currency")->value }})</p>
                                                                @endforeach
                                                                
                                                            @else
                                                                <p>No Drink</p>
                                                            @endif
                                                        </td>                                                        
                                                    </tr>
                                               @endforeach
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->


@endsection