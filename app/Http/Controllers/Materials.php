<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
<<<<<<< HEAD
use DB;
=======
use DB;	
>>>>>>> master

class Materials extends Controller
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
    
    public function index(Request $request){
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
            $unit_id = $this->site_model->fil_string($request->input('unit_id'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $quantity = $this->site_model->fil_string($request->input('quantity'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            $uq_id = $this->site_model->gen_uq_id('RMT');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($unit_id) || empty($supplier_id) || empty($quantity) || empty($cost) ){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/raw_materials');
                header("Location: $url");
                exit();
            }

            
            $r = DB::select("SELECT * FROM raw_materials WHERE name='$name'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Raw Material with name $name exists.
                            </div>";

                $url = url('/raw_materials');
=======
            $uq_id = $this->site_model->gen_uq_id("MTR");
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $unit = $this->site_model->fil_string($request->input('unit'));
            $name = $this->site_model->fil_string($request->input('name'));
            $quantity = $this->site_model->fil_string($request->input('quantity'));
            $cost = $this->site_model->fil_string($request->input('cost'));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/materials');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM raw_materials WHERE name='$name' OR uq_id='uq_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Raw Material already Exist.
                            </div>";

                $url = url('/materials');
>>>>>>> master
                header("Location: $url");
                exit();
            }
            else{
<<<<<<< HEAD
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'supplier_id'=>$supplier_id,
                    'unit_id'=>$unit_id,
=======
                $in_data = ['name'=>$name,
                    'supplier_id'=>$supplier_id,
                    'unit'=>$unit,
                    'uq_id'=>$uq_id,
>>>>>>> master
                    'quantity'=>$quantity,
                    'cost'=>$cost,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('raw_materials')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
<<<<<<< HEAD
                                SUCESSFULL: Raw Material Added
                            </div>";
                $url = url('/raw_materials');
=======
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/materials');
>>>>>>> master
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
<<<<<<< HEAD
            $raw_material_id = $request->input('raw_material_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $unit_id = $this->site_model->fil_string($request->input('unit_id'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $quantity = $this->site_model->fil_string($request->input('quantity'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            $uq_id = $this->site_model->gen_uq_id('RMT');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($unit_id) || empty($supplier_id) || empty($quantity) ){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/raw_materials');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM raw_materials WHERE id='$raw_material_id'");
            if(count($r) > 0){
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'supplier_id'=>$supplier_id,
                    'unit_id'=>$unit_id,
                    'quantity'=>$quantity,
                    'cost'=>$cost,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('raw_materials')
                        ->where('id', $raw_material_id)
=======
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $unit = $this->site_model->fil_string($request->input('unit'));
            $name = $this->site_model->fil_string($request->input('name'));
            $quantity = $this->site_model->fil_string($request->input('quantity'));
            $cost = $this->site_model->fil_string($request->input('cost'));
            
            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/materials');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM raw_materials WHERE name='$name' AND id!='$c_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                ERROR: $name is assigned.
                            </div>";
                $url = url('/materials');
                header("Location: $url");
                exit();   
            }
            else{
                $in_data = ['name'=>$name,
                    'supplier_id'=>$supplier_id,
                    'unit'=>$unit,
                    'quantity'=>$quantity,
                    'cost'=>$cost,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                ];

                DB::table('raw_materials')
                        ->where('id', $c_id)
>>>>>>> master
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
<<<<<<< HEAD
                                SUCESSFULL: Raw Material Updated.
                            </div>";
                $url = url('/raw_materials');
=======
                                SUCESSFULL: Record Updated.
                            </div>";
                $url = url('/materials');
>>>>>>> master
                header("Location: $url");
                exit();    
            }


            
        }

        if(isset($_POST['delete'])){
<<<<<<< HEAD
            $raw_material_id = $request->input('raw_material_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');
=======
            $c_id = $request->input('c_id');
>>>>>>> master

            $date = date("Y-m-d H:i:s");


<<<<<<< HEAD
            if(empty($raw_material_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Raw Material id not set
                            </div>";
                $url = url('/raw_materials');
=======
            if(empty($c_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Operation Failed.
                                </div>";
                $url = url('/machines');
>>>>>>> master
                header("Location: $url");
                exit();
            }

<<<<<<< HEAD
            DB::table('raw_materials')->where('id', '=', $raw_material_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Raw Material Deleted.
                        </div>";
            $url = url('/raw_materials');
            header("Location: $url");
            exit();


            
        }

        $data['page_title'] = "Raw Materials";
        
        echo view('header', $data);
        echo view('raw_materials', $data);
=======
            DB::table('raw_materials')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/materials');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Materials";
        
        echo view('materials', $data);
>>>>>>> master
        echo view('footer');
        exit();
        // exit();
    }
}
