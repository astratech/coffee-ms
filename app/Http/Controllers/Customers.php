<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Customers extends Controller
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
            $mobile = $this->site_model->fil_string($request->input('mobile'));
            $email = $this->site_model->fil_string($request->input('email'));
            $address = $this->site_model->fil_string($request->input('address'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($mobile) || empty($email) || empty($address)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/customers');
                header("Location: $url");
                exit();
            }

            
            $r = DB::select("SELECT * FROM customers WHERE email='$email'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Customer with email $email exists.
                            </div>";

                $url = url('/customers');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'mobile'=>$mobile,
                    'email'=>$email,
                    'address'=>$address,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('customers')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Customer Added
                            </div>";
                $url = url('/customers');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
            $customer_id = $request->input('customer_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $mobile = $this->site_model->fil_string($request->input('mobile'));
            $email = $this->site_model->fil_string($request->input('email'));
            $address = $this->site_model->fil_string($request->input('address'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($mobile) || empty($email) || empty($address)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/customers');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM customers WHERE id='$customer_id'");
            if(count($r) > 0){
                $in_data = ['name'=>$name,
                	'mobile'=>$mobile,
                	'email'=>$email,
                	'address'=>$address,
                    'updated_at'=>$date,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id
                ];

                DB::table('customers')
                        ->where('id', $customer_id)
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Customer Updated.
                            </div>";
                $url = url('/customers');
                header("Location: $url");
                exit();    
            }


            
        }

        if(isset($_POST['delete'])){
            $customer_id = $request->input('customer_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($customer_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Customer id not set
                            </div>";
                $url = url('/customers');
                header("Location: $url");
                exit();
            }

            DB::table('customers')->where('id', '=', $customer_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Customer Deleted.
                        </div>";
            $url = url('/customers');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Customers";
        
        echo view('customers', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
