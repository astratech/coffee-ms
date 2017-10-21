<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;


class Dashboard extends Controller{

	public function __construct() {
        $this->site_model = new Site;

        if(!isset($_SESSION['coffee_staff_logged'])){
            $url = url('/login');
            header("Location: $url");
            exit();
        }
        else{
            $this->staff_id = $_SESSION['coffee_staff_logged']['id'];
        }
    }

    
    public function index(Request $request){


        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['add_product'])){
            $rent_id = $this->site_model->fil_num($request->input('rent_id'));
            $product_id = $this->site_model->fil_num($request->input('product_id'));
            $quantity = $this->site_model->fil_num($request->input('quantity'));
            
            $date = date("Y-m-d H:i:s");

            if(empty($quantity)){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Enter Quantity.
                            </div>";

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            $available = Site::calc_prod_qty_available($product_id);

            if($quantity > $available){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Only $available Quantity is available for the product.
                            </div>";

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM rent_products WHERE rent_id='$rent_id' AND product_store_id='$product_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> This Product is already added to this Rent.
                            </div>";

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['rent_id'=>$rent_id,
                    'product_store_id'=>$product_id,
                    'quantity'=>$quantity,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    ];

                DB::table('rent_products')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Product Added to Rent.
                            </div>";
                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }
        }

        if(isset($_POST['add_drink'])){
            $rent_id = $this->site_model->fil_string($request->input('rent_id'));
            $drink_id = $this->site_model->fil_string($request->input('drink_id'));
            $cost = $this->site_model->fil_num($request->input('cost'));
            
            $date = date("Y-m-d H:i:s");

            if(empty($cost)){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Enter Cost of Drink.
                            </div>";

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM rent_drinks WHERE rent_id='$rent_id' AND drink_id='$drink_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> This Drink is already added to this Rent.
                            </div>";

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['rent_id'=>$rent_id,
                    'drink_id'=>$drink_id,
                    'cost'=>$cost,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    ];

                DB::table('rent_drinks')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Drink Added to Rent.
                            </div>";
                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }
        }

        if(isset($_POST['create'])){
            $uq_id = $this->site_model->gen_uq_id("RNT");
            $customer_id = $this->site_model->fil_num($request->input('customer_id'));
            $machine_id = $this->site_model->fil_num($request->input('machine_id'));
            $price = $this->site_model->fil_num($request->input('price'));
            $date_from = date("y-m-d", strtotime($request->input('date_from')));
            $date_to = date("y-m-d", strtotime($request->input('date_to')));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {
                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/dashboard');
                    header("Location: $url");
                    exit();
                }
            }

            $in_data = ['customer_id'=>$customer_id,
                'machine_id'=>$machine_id,
                'price'=>$price,
                'date_to'=>$date_to,
                'date_from'=>$date_from,
                'uq_id'=>$uq_id,
                'created_at'=>$date,
                'created_by'=>$this->staff_id,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
                ];

            DB::table('rents')->insert($in_data);

            // update Machine is rented
            DB::table('machines')
                        ->where('id', $machine_id)
                        ->update(['is_rented'=>1]);

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Added
                        </div>";
            $url = url('/dashboard');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $name = $this->site_model->fil_string($request->input('name'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            
            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/drinks');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM drinks WHERE name='$name' AND id!='$c_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                ERROR: $name is assigned.
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();   
            }
            else{
                $in_data = ['name'=>$name,
                    'cost'=>$cost,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                ];

                DB::table('drinks')
                        ->where('id', $c_id)
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Updated.
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();    
            }

        }

        if(isset($_POST['update_settings'])){
            $currency = $request->input('currency');

            $date = date("Y-m-d H:i:s");

            if(empty($currency)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            $in_data = [
                'value'=>$currency,
                'updated_at'=>$date,
            ];

            DB::table('settings')
                    ->where('name', 'currency')
                    ->update($in_data);


            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Settings Updated.
                        </div>";
            $url = url('/dashboard');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['delete'])){
            $c_id = $request->input('c_id');

            $date = date("Y-m-d H:i:s");


            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            DB::beginTransaction();

            DB::table('rents')->where('id', '=', $c_id)->delete();
            DB::table('rent_drinks')->where('rent_id', '=', $c_id)->delete();

            $s = DB::select("SELECT * FROM sales WHERE rent_id='$c_id'");
            foreach ($s as $sr){
                $se = DB::select("SELECT * FROM sales_entry WHERE sales_id='$sr->id'");

                foreach ($se as $ser){
                    DB::table('sales_entry')->where('id', '=', $ser->id)->delete();
                }

                DB::table('sales')->where('id', '=', $sr->id)->delete();
            }

            DB::commit();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/dashboard');
            header("Location: $url");
            exit();
            
        }

        if(isset($_POST['delete_drink'])){
            $c_id = $request->input('c_id');

            $date = date("Y-m-d H:i:s");


            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }

            DB::table('rent_drinks')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/dashboard');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Dashboard";

        
        echo view('dashboard', $data);
        echo view('footer');
        exit();
    }

    public function invoice(Request $request, $rent_uq_id){

        // echo "$rent_uq_id";
        // exit();

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        $uq_id = $this->site_model->fil_string($rent_uq_id);

        $r = DB::select("SELECT * FROM rents WHERE uq_id='$uq_id'");
        if(count($r) > 0){
            foreach ($r as $d){
                $data['rent_id'] = $d->id;
                $data['rent_uq_id'] = $d->uq_id;
                $data['rent_customer_id'] = $d->customer_id;
                $data['rent_machine_id'] = $d->machine_id;
                $data['rent_price'] = $d->price;
                $data['rent_date_from'] = $d->date_from;
                $data['rent_date_to'] = $d->date_to;
            }
        }
        else{
            $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            <strong>ERROR: </strong> Rent record not found.
                        </div>";

            $url = url('/dashboard');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
            // var_dump($request->input("unit"));
            // exit();
            
            $rent_id = $request->input("rent_id");
            $count = count($request->input("unit"));
            $sale_uq_id = $this->site_model->gen_uq_id("SALES");

            $date = date("Y-m-d H:i:s");
            $date_recorded = date("y-m-d", strtotime($request->input('date_recorded')));

            DB::beginTransaction();

            $in_data = ['rent_id'=>$rent_id,
                'date_recorded'=>$date_recorded,
                'uq_id'=>$sale_uq_id,
                'created_at'=>$date,
                'created_by'=>$this->staff_id,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
                ];

            $sales_id = DB::table('sales')->insertGetId($in_data);
            
            // echo "$sales_id";
            // exit();

            for($i=0; $i<$count; $i++){
                $unit = $_POST['unit']["$i"];
                $drink_id = $_POST['drink_id']["$i"];
                

                if(empty($unit) OR empty($drink_id) OR empty($rent_id)) {
                    DB::rollBack();

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url("/accounting/add/$uq_id");
                    header("Location: $url");
                    exit();
                }

                
                $qq = DB::select("SELECT * FROM rent_drinks WHERE drink_id='$drink_id' ORDER BY id DESC");
                foreach ($qq as $qi){
                    $cost = $qi->cost;
                }

                $amount = $unit * $cost;

                $in_data = ['sales_id'=>$sales_id,
                    'drink_id'=>$drink_id,
                    'date_recorded'=>$date_recorded,
                    'num_of_purchase'=>$unit,
                    'amount'=>$amount,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                ];

                DB::table('sales_entry')->insert($in_data);
            }

            DB::commit();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Added
                        </div>";
            $url = url('/accounting');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $drink_id = $this->site_model->fil_num($request->input('drink_id'));
            $rent_id = $this->site_model->fil_num($request->input('rent_id'));
            $num_of_purchase = $this->site_model->fil_num($request->input('num_of_purchase'));
            $date_recorded = date("y-m-d", strtotime($request->input('date_recorded')));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/accounting');
                    header("Location: $url");
                    exit();
                }
            }

            $cost = $this->site_model->get_record("drinks", $drink_id)->cost;

            $amount = $num_of_purchase * $cost;

            $in_data = ['rent_id'=>$rent_id,
                'drink_id'=>$drink_id,
                'num_of_purchase'=>$num_of_purchase,
                'date_recorded'=>$date_recorded,
                'amount'=>$amount,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
            ];

            DB::table('sales')
                    ->where('id', $c_id)
                    ->update($in_data);


            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Updated.
                        </div>";
            $url = url('/accounting');
            header("Location: $url");
            exit();    

        }

        if(isset($_POST['delete'])){
            $c_id = $request->input('c_id');

            $date = date("Y-m-d H:i:s");


            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
                $url = url('/accounting');
                header("Location: $url");
                exit();
            }

            DB::table('sales')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/accounting');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Invoice | $uq_id";
        
        echo view('invoice', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
