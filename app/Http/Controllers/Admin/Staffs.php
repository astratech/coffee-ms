<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Site;
use App\Http\Controllers\Controller;
use DB;

class Staffs extends Controller{

	public function __construct() {
        $this->site_model = new Site;
    }

    
    public function index(Request $request){


        if(isset($_POST['create'])){
            $name = $this->site_model->fil_string($request->input('name'));
            $dept = $this->site_model->fil_string($request->input('dept'));
            $email = $this->site_model->fil_email($request->input('email'));
            $password = $request->input('password');
            $uq_id = $this->site_model->gen_uq_id('STF');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($dept) || empty($email) || empty($password)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/admin/staffs');
                header("Location: $url");
                exit();
            }

            $password = $this->site_model->encode_password($password);

            $r = DB::select("SELECT * FROM staffs WHERE email='$email'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Staff with email $email exists.
                            </div>";

                $url = url('/admin/staffs');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['name'=>$name,
                    'dept'=>$dept,
                    'email'=>$email,
                    'password'=>$password,
                    'uq_id'=>$uq_id,
                    'created_at'=>$date,
                    'created_by'=>'1'
                    ];

                DB::table('staffs')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Staff Added
                            </div>";
                $url = url('/admin/staffs');
                header("Location: $url");
                exit();
            }
        }

        echo view('admin_staff');
        
        exit();
        // exit();
    }
}
