<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Products extends Controller
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

    
    public function index(Request $request){

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
            $uq_id = $this->site_model->gen_uq_id("MTR");
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            
            $product_list_id = $this->site_model->fil_num($request->input('product_list_id'));
            $cost = $this->site_model->fil_num($request->input('cost'));
            $quantity = $this->site_model->fil_num( $request->input('quantity'));


            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/products');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM products WHERE uq_id='uq_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Raw Material already Exist.
                            </div>";

                $url = url('/products');
                header("Location: $url");
                exit();
            }
            else{
                $price_per_qty = Site::get_record("product_list", $product_list_id)->price_per_qty;

                $in_data = ['product_list_id'=>$product_list_id,
                    'supplier_id'=>$supplier_id,
                    'uq_id'=>$uq_id,
                    'cost'=>$cost,
                    'quantity'=>$quantity,
                    'price_per_qty'=>$price_per_qty,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('products')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/products');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $product_list_id = $this->site_model->fil_num($request->input('product_list_id'));
            $cost = $this->site_model->fil_num($request->input('cost'));
            $quantity = $this->site_model->fil_num( $request->input('quantity'));
            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/products');
                    header("Location: $url");
                    exit();
                }
            }

            $price_per_qty = Site::get_record("product_list", $product_list_id)->price_per_qty;
            $in_data = ['product_list_id'=>$product_list_id,
                'supplier_id'=>$supplier_id,
                'cost'=>$cost,
                'quantity'=>$quantity,
                'price_per_qty'=>$price_per_qty,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
            ];

            DB::table('products')
                    ->where('id', $c_id)
                    ->update($in_data);


            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Updated.
                        </div>";
            $url = url('/products');
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
                $url = url('/machines');
                header("Location: $url");
                exit();
            }

            DB::table('products')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/products');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Products Store";
        
        echo view('materials', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
