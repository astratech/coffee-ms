<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Machines extends Controller
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
            $company_name = $this->site_model->fil_string($request->input('company_name'));
            $model = $this->site_model->fil_string($request->input('model'));
            $serial_num = $this->site_model->fil_string($request->input('serial_num'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $price = $this->site_model->fil_string($request->input('price'));
            $counter_status = $this->site_model->fil_string($request->input('counter_status'));
            $leasing_rate = $this->site_model->fil_string($request->input('leasing_rate'));
            $uq_id = $this->site_model->fil_string($request->input('uq_id'));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/machines');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM machines WHERE uq_id='$uq_id' OR model='$model'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Machine Code or Model Exists.
                            </div>";

                $url = url('/machines');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['uq_id'=>$uq_id,
                    'company_name'=>$company_name,
                    'model'=>$model,
                    'serial_num'=>$serial_num,
                    'supplier_id'=>$supplier_id,
                    'price'=>$price,
                    'counter_status'=>$counter_status,
                    'leasing_rate'=>$leasing_rate,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('machines')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Machine Added
                            </div>";
                $url = url('/machines');
                header("Location: $url");
                exit();
            }
        }

        if(isset($_POST['add_drink'])){
            $machine_id = $this->site_model->fil_string($request->input('machine_id'));
            $drink_id = $this->site_model->fil_string($request->input('drink_id'));
            
            $date = date("Y-m-d H:i:s");

            $r = DB::select("SELECT * FROM machine_drinks WHERE machine_id='$machine_id' AND drink_id='$drink_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> This Drink is already added to this Machine.
                            </div>";

                $url = url('/machines');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['machine_id'=>$machine_id,
                    'drink_id'=>$drink_id,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    ];

                DB::table('machine_drinks')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Drink Added to Machine.
                            </div>";
                $url = url('/machines');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
            $company_name = $this->site_model->fil_string($request->input('company_name'));
            $model = $this->site_model->fil_string($request->input('model'));
            $serial_num = $this->site_model->fil_string($request->input('serial_num'));
            $supplier_id = $this->site_model->fil_string($request->input('supplier_id'));
            $price = $this->site_model->fil_string($request->input('price'));
            $counter_status = $this->site_model->fil_string($request->input('counter_status'));
            $leasing_rate = $this->site_model->fil_string($request->input('leasing_rate'));
            $uq_id = $this->site_model->fil_string($request->input('uq_id'));
            $c_id = $this->site_model->fil_string($request->input('c_id'));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val) OR empty($c_id)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/machines');
                    header("Location: $url");
                    exit();
                }
            }

            $r = DB::select("SELECT * FROM machines WHERE (model='$model' OR serial_num='$serial_num') AND id!='$c_id'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                ERROR: Model-Number:model or Serial-Num: $serial_num is assigned to another Machine.
                            </div>";
                $url = url('/machines');
                header("Location: $url");
                exit();   
            }
            else{
                $in_data = ['uq_id'=>$uq_id,
                    'company_name'=>$company_name,
                    'model'=>$model,
                    'serial_num'=>$serial_num,
                    'supplier_id'=>$supplier_id,
                    'price'=>$price,
                    'counter_status'=>$counter_status,
                    'leasing_rate'=>$leasing_rate,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                ];

                DB::table('machines')
                        ->where('id', $c_id)
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Updated.
                            </div>";
                $url = url('/machines');
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
                $url = url('/machines');
                header("Location: $url");
                exit();
            }

            DB::table('machines')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/machines');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Machines";
        
        echo view('machines', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
