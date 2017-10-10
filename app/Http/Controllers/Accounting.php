<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;	

class Accounting extends Controller
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
            $uq_id = $this->site_model->gen_uq_id("SALES");
            $drink_id = $this->site_model->fil_num($request->input('drink_id'));
            $rent_id = $this->site_model->fil_num($request->input('rent_id'));
            $num_of_purchase = $this->site_model->fil_num($request->input('num_of_purchase'));
            $date_recorded = date("y-m-d", strtotime($request->input('date_recorded')));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/accounting');
                    header("Location: $url");
                    exit();
                }
            }

            $cost = $this->site_model->get_record("drinks", $drink_id)->cost;

            $amount = $num_of_purchase * $cost;

                $in_data = ['rent_id'=>$rent_id,
                    'drink_id'=>$drink_id,
                    'num_of_purchase'=>$num_of_purchase,
                    'date_recorded'=>$date_recorded,
                    'uq_id'=>$uq_id,
                    'amount'=>$amount,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('sales')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/accounting');
                header("Location: $url");
                exit();
        }

        

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_string($request->input('c_id'));
            $drink_id = $this->site_model->fil_num($request->input('drink_id'));
            $rent_id = $this->site_model->fil_num($request->input('rent_id'));
            $num_of_purchase = $this->site_model->fil_num($request->input('num_of_purchase'));
            $date_recorded = date("y-m-d", strtotime($request->input('date_recorded')));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val)) {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/accounting');
                    header("Location: $url");
                    exit();
                }
            }

            $cost = $this->site_model->get_record("drinks", $drink_id)->cost;

            $amount = $num_of_purchase * $cost;

            $in_data = ['rent_id'=>$rent_id,
                'drink_id'=>$drink_id,
                'num_of_purchase'=>$num_of_purchase,
                'date_recorded'=>$date_recorded,
                'amount'=>$amount,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
            ];

            DB::table('sales')
                    ->where('id', $c_id)
                    ->update($in_data);


            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Updated.
                        </div>";
            $url = url('/accounting');
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
                $url = url('/accounting');
                header("Location: $url");
                exit();
            }

            DB::table('sales')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/accounting');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Accounting";
        
        echo view('accounting', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
