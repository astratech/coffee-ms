<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Schema;
use DB;	

class Maintenance extends Controller
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

            $machine_id = $this->site_model->fil_num($request->input('machine_id')); 
            $cost = $this->site_model->fil_num($request->input('cost')); 
            $note = $this->site_model->fil_text($request->input('note')); 
            $maintenance_date = date("y-m-d", strtotime($request->input('maintenance_date')));

            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if (empty($val) AND $key != "note") {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/maintenance');
                    header("Location: $url");
                    exit();
                }
            }


                $in_data = ['machine_id'=>$machine_id,
                    'cost'=>$cost,
                    'note'=>$note,
                    'maintenance_date'=>$maintenance_date,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('maintenance')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Record Added
                            </div>";
                $url = url('/maintenance');
                header("Location: $url");
                exit();
        }

        

        if(isset($_POST['update'])){
            $c_id = $this->site_model->fil_num($request->input('c_id'));
            $machine_id = $this->site_model->fil_num($request->input('machine_id')); 
            $cost = $this->site_model->fil_num($request->input('cost')); 
            $note = $this->site_model->fil_text($request->input('note')); 
            $maintenance_date = date("y-m-d", strtotime($request->input('maintenance_date')));
            
            $date = date("Y-m-d H:i:s");

            foreach ($_POST as $key => $val) {
                if ((empty($val) OR empty($c_id)) AND $key != "note") {

                    $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                    $url = url('/maintenance');
                    header("Location: $url");
                    exit();
                }
            }


            $in_data = ['machine_id'=>$machine_id,
                'cost'=>$cost,
                'note'=>$note,
                'maintenance_date'=>$maintenance_date,
                'updated_by'=>$this->staff_id,
                'updated_at'=>$date
            ];

            DB::table('maintenance')
                    ->where('id', $c_id)
                    ->update($in_data);


            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Updated.
                        </div>";
            $url = url('/maintenance');
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
                $url = url('/maintenance');
                header("Location: $url");
                exit();
            }

            DB::table('maintenance')->where('id', '=', $c_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Record Deleted.
                        </div>";
            $url = url('/maintenance');
            header("Location: $url");
            exit();
            
        }

        $data['page_title'] = "Maintenance Records";
        
        echo view('maintenance', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
