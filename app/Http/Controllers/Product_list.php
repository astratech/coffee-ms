<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Schema;
use DB;	

class Product_list extends Controller
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

            $name = $this->site_model->fil_string($request->input('name')); 
            $unit = $this->site_model->fil_string($request->input('unit')); 

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/product_list');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM product_list WHERE name='$name'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> $name already Exist.
                            </div>";

                $url = url('/product_list');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['name'=>$name,
                    'unit'=>$unit,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('product_list')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/product_list');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_num($request->input('c_id'));
            $name = $this->site_model->fil_string($request->input('name'));
            $unit = $this->site_model->fil_string($request->input('unit'));
            
            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val) OR empty($c_id)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/products');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM product_list WHERE name='$name' AND id!='$c_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                ERROR: $name is assigned.
                            </div>";
                $url = url('/product_list');
                header("Location: $url");
                exit();   
            }
            else{
                $in_data = ['name'=>$name,
                    'unit'=>$unit,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                ];

                DB::table('product_list')
                        ->where('id', $c_id)
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Updated.
                            </div>";
                $url = url('/product_list');
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
                $url = url('/product_list');
                header("Location: $url");
                exit();
            }

            DB::table('product_list')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/product_list');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Product List";
        
        echo view('product_list', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
