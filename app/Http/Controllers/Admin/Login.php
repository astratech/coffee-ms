<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Site;
use App\Http\Controllers\Controller;
use DB;

class Login extends Controller{

	public function __construct() {
        $this->site_model = new Site;
    }

    
    public function index(Request $request){

    	if(isset($_POST['login'])){
    		$username = $request->input('username');
    		$password = $request->input('password');

    		if(empty($username) || empty($password)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/admin/login');
                header("Location: $url");
                exit();
            }

            $password = $this->site_model->encode_password($password);

			$r = DB::select("SELECT * FROM admin WHERE username='$username' AND password='$password'");
	    	if(count($r) > 0){
	    		$url = url('/admin/staffs');
                header("Location: $url");
                exit();
	    	}
	    	else{
	    		$_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Invalid Details
                            </div>";
                $url = url('/admin/login');
                header("Location: $url");
                exit();
	    	}
		}

    	echo view('admin_login');
        unset($_SESSION['notification']);
        exit();
    }
}
