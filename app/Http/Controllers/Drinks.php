<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
<<<<<<< HEAD
use DB;
=======
use DB;	
>>>>>>> master

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

<<<<<<< HEAD
        public function index(Request $request){
=======
    
<<<<<<< HEAD
    public function index(Request $request){
>>>>>>> master
=======
    public function index(Request $request, $drink_id = NULL){
>>>>>>> master

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
<<<<<<< HEAD
            $name = $this->site_model->fil_string($request->input('name'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            $num_of_materials = $this->site_model->fil_string($request->input('num_of_materials'));
            $uq_id = $this->site_model->gen_uq_id('DRK');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($cost) || empty($num_of_materials) ){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }

            
            $r = DB::select("SELECT * FROM drinks WHERE name='$name'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Drink with name $name exists.
=======
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
>>>>>>> master
                            </div>";

                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
            else{
<<<<<<< HEAD
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'cost'=>$cost,
                    'num_of_materials'=>$num_of_materials,
=======
                $in_data = ['name'=>$name,
                    'uq_id'=>$uq_id,
>>>>>>> master
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('drinks')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
<<<<<<< HEAD
                                SUCESSFULL: Drink Added
=======
                                SUCESSFULL: Record Added
>>>>>>> master
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
        }

        if(isset($_POST['update'])){
<<<<<<< HEAD
            $drink_id = $request->input('drink_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            $num_of_materials = $this->site_model->fil_string($request->input('num_of_materials'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($cost) || empty($num_of_materials)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM drinks WHERE id='$drink_id'");
            if(count($r) > 0){
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'cost'=>$cost,
                    'num_of_materials'=>$num_of_materials,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('drinks')
                        ->where('id', $drink_id)
=======
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
>>>>>>> master
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
<<<<<<< HEAD
                                SUCESSFULL: Drink Updated.
=======
                                SUCESSFULL: Record Updated.
>>>>>>> master
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
<<<<<<< HEAD
            $drink_id = $request->input('drink_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');
=======
            $c_id = $request->input('c_id');
>>>>>>> master

            $date = date("Y-m-d H:i:s");


<<<<<<< HEAD
            if(empty($drink_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Drink id not set
                            </div>";
=======
            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
>>>>>>> master
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }

<<<<<<< HEAD
            DB::table('drinks')->where('id', '=', $drink_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Drink Deleted.
=======
            DB::table('drinks')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
>>>>>>> master
                        </div>";
            $url = url('/drinks');
            header("Location: $url");
            exit();
<<<<<<< HEAD


=======
>>>>>>> master
            
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
        
<<<<<<< HEAD
        echo view('header', $data);
=======
>>>>>>> master
        echo view('drinks', $data);
        echo view('footer');
        exit();
        // exit();
    }
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> master
=======

    public function view(Request $request, $drink_id){

    }
>>>>>>> master
}
