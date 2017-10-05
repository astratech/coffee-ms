<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;


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
                $url = url('/login');
                header("Location: $url");
                exit();
            }

			$r = DB::select("SELECT * FROM users WHERE username='$username' AND password='$password'");
	    	if(count($r) > 0){
	    		$output = $r;
	    	}
	    	else{
	    		
	    	}
		}

    	return view('login');
    }
}
