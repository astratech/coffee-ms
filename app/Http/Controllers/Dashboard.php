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

        if(isset($_POST['add_drink'])){
            $rent_id = $this->site_model->fil_string($request->input('rent_id'));
            $drink_id = $this->site_model->fil_string($request->input('drink_id'));
            
            $date = date("Y-m-d H:i:s");

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
            $customer_id = $this->site_model->fil_string($request->input('customer_id'));
            $machine_id = $this->site_model->fil_string($request->input('machine_id'));

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
                'uq_id'=>$uq_id,
                'created_at'=>$date,
                'created_by'=>$this->staff_id,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
                ];

            DB::table('rents')->insert($in_data);

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

            DB::table('rents')->where('id', '=', $c_id)->delete();

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
        // exit();
    }
}
