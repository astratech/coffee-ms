<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Report extends Controller
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

    
    public function index($uq_id){

        if(isset($_POST['logout'])){
            unset($_SESSION['coffee_admin_logged']);

            $url = url('/login');
            header("Location: $url");
            exit();
        }

        // echo "$uq_id";
        // exit();
        $uq_id = $this->site_model->fil_string($uq_id);

        $r = DB::select("SELECT * FROM sales WHERE uq_id='$uq_id'");
        if(count($r) > 0){
            foreach ($r as $d){
                $data['sales_id'] = $d->id;
                $data['sales_uq_id'] = $d->uq_id;
            }
        }
        else{
            $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            <strong>ERROR: </strong> SALES record not found.
                        </div>";

            $url = url('/accounting');
            header("Location: $url");
            exit();
        }

        $data['page_title'] = "Sales Report";
        
        echo view('report', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
