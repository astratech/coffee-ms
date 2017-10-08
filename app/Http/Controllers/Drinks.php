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

        public function index(Request $request){

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
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
                            </div>";

                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'cost'=>$cost,
                    'num_of_materials'=>$num_of_materials,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('drinks')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Drink Added
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
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
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Drink Updated.
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();    
            }


            
        }

        if(isset($_POST['delete'])){
            $drink_id = $request->input('drink_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($drink_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Drink id not set
                            </div>";
                $url = url('/drinks');
                header("Location: $url");
                exit();
            }

            DB::table('drinks')->where('id', '=', $drink_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Drink Deleted.
                        </div>";
            $url = url('/drinks');
            header("Location: $url");
            exit();


            
        }

        $data['page_title'] = "Drinks";
        
        echo view('header', $data);
        echo view('drinks', $data);
        echo view('footer');
        exit();
        // exit();
    }

}
