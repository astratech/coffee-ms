<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;


class Login extends Controller{

    public function __construct() {
        $this->site_model = new Site;

        if(isset($_SESSION['coffee_staff_logged'])){
            $url = url('/dashboard');
            header("Location: $url");
            exit();
        }
          
    }

    
    public function index(Request $request){

        if(isset($_POST['login'])){
            $email = $request->input('email');
            $password = $request->input('password');

            if(empty($email) || empty($password)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/login');
                header("Location: $url");
                exit();
            }

            $password = $this->site_model->encode_password($password);

            $r = DB::select("SELECT * FROM staffs WHERE email='$email' AND password='$password'");
            if(count($r) > 0){
                
                foreach ($r as $d){
                    $_SESSION['coffee_staff_logged']['id'] = $d->id;
                }

                $url = url('/dashboard');
                header("Location: $url");
                exit();
            }
            else{
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Invalid Details
                            </div>";
                $url = url('/login');
                header("Location: $url");
                exit();
            }
        }
        $data['page_title'] = "Login";

        echo view('login');
        unset($_SESSION['notification']);
        exit();
    }
}

