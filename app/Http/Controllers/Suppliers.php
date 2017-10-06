<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use DB;


class Suppliers extends Controller{

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

            $url = url('/admin/staffs');
            header("Location: $url");
            exit();
        }

        if(isset($_POST['create'])){
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($contact)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/suppliers');
                header("Location: $url");
                exit();
            }

            
            $r = DB::select("SELECT * FROM suppliers WHERE name='$name'");
            if(count($r) > 0){
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Staff with email $email exists.
                            </div>";

                $url = url('/suppliers');
                header("Location: $url");
                exit();
            }
            else{
                $in_data = ['uq_id'=>$uq_id,
                    'name'=>$name,
                    'contact_info'=>$contact,
                    'created_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id,
                    'updated_at'=>$date
                    ];

                DB::table('suppliers')->insert($in_data);

                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Supplier Added
                            </div>";
                $url = url('/suppliers');
                header("Location: $url");
                exit();
            }
        }

        

        if(isset($_POST['update'])){
            $supplier_id = $request->input('supplier_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($name) || empty($contact)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Fill the empty fields
                            </div>";
                $url = url('/suppliers');
                header("Location: $url");
                exit();
            }

            $r = DB::select("SELECT * FROM suppliers WHERE id='$supplier_id'");
            if(count($r) > 0){
                $in_data = ['name'=>$name,
                    'contact_info'=>$contact,
                    'updated_at'=>$date,
                    'created_by'=>$this->staff_id,
                    'updated_by'=>$this->staff_id
                ];

                DB::table('suppliers')
                        ->where('id', $supplier_id)
                        ->update($in_data);


                $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                SUCESSFULL: Supplier Updated.
                            </div>";
                $url = url('/suppliers');
                header("Location: $url");
                exit();    
            }


            
        }

        if(isset($_POST['delete'])){
            $supplier_id = $request->input('supplier_id');
            $name = $this->site_model->fil_string($request->input('name'));
            $contact = $this->site_model->fil_string($request->input('contact'));
            $uq_id = $this->site_model->gen_uq_id('SUP');

            $date = date("Y-m-d H:i:s");


            if(empty($supplier_id)){
                //set notification session
                $_SESSION['notification'] = "<div class='alert alert-callout alert-danger alert-dismissable' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                                <strong>ERROR: </strong> Supplier id not set
                            </div>";
                $url = url('/suppliers');
                header("Location: $url");
                exit();
            }

            DB::table('suppliers')->where('id', '=', $supplier_id)->delete();

            $_SESSION['notification'] = "<div class='alert alert-callout alert-success alert-dismissable' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
                            SUCESSFULL: Supplier Deleted.
                        </div>";
            $url = url('/suppliers');
            header("Location: $url");
            exit();


            
        }

        $data['page_title'] = "Suppliers";
        
        echo view('suppliers', $data);
        echo view('footer');
        exit();
        // exit();
    }
}
