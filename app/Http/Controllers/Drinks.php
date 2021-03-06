<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Drinks extends Controller
{
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

    
    public function index(Request $request, $drink_id = NULL){

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
            $uq_id = $this->site_model->gen_uq_id("DRK");
            $name = $this->site_model->fil_string($request->input('name'));

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

            $r = DB::select("SELECT * FROM drinks WHERE name='$name' OR uq_id='uq_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Drink already Exist.
                            </div>";

                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['name'=>$name,
                    'uq_id'=>$uq_id,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('drinks')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
        }

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $name = $this->site_model->fil_string($request->input('name'));
            
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

        if(isset($_POST['add_material'])){
            $product_list_id = $this->site_model->fil_num($request->input('product_list_id'));
            $drink_id = $this->site_model->fil_num($request->input('drink_id'));
            $quantity = $this->site_model->fil_num($request->input('quantity'));

            
            $date = date("Y-m-d H:i:s");

            if(empty($product_list_id) OR empty($drink_id)){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                            </div>";

                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();
            }

            if(empty($quantity)){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";

                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();
            }

            if($quantity < 1 ){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Invalid Input for quantity.
                            </div>";

                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM drink_products WHERE drink_id='$drink_id' AND product_list_id='$product_list_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                ERROR: product is assigned.
                            </div>";
                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();   
            }
            else{

                $in_data = ['product_list_id'=>$product_list_id,
                    'drink_id'=>$drink_id,
                    'quantity'=>$quantity,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_at'=>$date,
                    'updated_by'=>$this->staff_id,
                    ];

                DB::table('drink_products')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();
            }
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
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }

            DB::table('drinks')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/drinks');
            header("Location: $url");
            exit();
            
        }

        if(isset($_POST['delete_material'])){
            $c_id = $request->input('c_id');

            $date = date("Y-m-d H:i:s");


            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
                $url = url("/drinks/$drink_id");
                header("Location: $url");
                exit();
            }

            DB::table('drink_products')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url("/drinks/$drink_id");
            header("Location: $url");
            exit();
            
        }

        if(!is_null($drink_id)){
            $r = DB::select("SELECT * FROM drinks WHERE id='$drink_id'");
            if(count($r) > 0){
                $data['page_type'] = "single";
                $data['drink_id'] = $drink_id;
            }
            else{
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
        }

        $data['page_title'] = "Drinks";
        
        echo view('drinks', $data);
        echo view('footer');
        exit();
        // exit();
    }

    public function view(Request $request, $drink_id){

    }
}
