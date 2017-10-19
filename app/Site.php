<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Schema;
use DB;

session_start();
class Site extends Model{
  

    public static function fil_email($str){
        $val = preg_replace("/[^A-Za-z0-9_.-@]/", "", $str);
        return $val;
    }

    public static function fil_num($str){
        $val = preg_replace("/[^0-9]/", "", $str);
        return $val;
    }

    public static function fil_text($str){
        $val = preg_replace("/[^A-Za-z0-9,_.\-@() ]/", "", $str);
        return $val;
    }

    public static function fil_string($str){
        $val = preg_replace("/[^A-Za-z0-9_.\- ]/", "", $str);
        return $val;
    }

    public static function fil_password($str){
        $val = preg_replace("/[^A-Za-z0-9_.\-@!#$%&*() ]/", "", $str);
        return $val;
    }
    
    public static function encode_password($t) {
        $a = "sdfwe";
		$b = "sjjd7";
		//encode pass
		$r = base64_encode($t);
		//add pre salt
		$r = $a.$r;
		return $r;
    }

    public static function decode_password($t) {
		$r = substr($t, 5);
		$r = base64_decode($r);
		return $r;
    }

    public static function gen_uq_id($txt) {
        // $a = uniqid();
        $a = mt_rand(9000,9000000);
        $r = $txt.substr(str_shuffle($a),0, 4);
        return strtoupper($r);
    }

    public static function gen_token() {
        $a = mt_rand(9000,9000000);
        $r = substr(str_shuffle($a),0, 6);
        return strtoupper($r);
    }

    public static function get_records($table){
        return DB::select("SELECT * FROM $table ORDER BY id DESC");
         
    }

    public static function get_record($table, $id){
        $r = DB::select("SELECT * FROM $table WHERE id='$id'");
        $output = [];
        if(count($r) > 0){
            foreach ($r as $value) {
                $output = $value;
            }
        }
        else{
             foreach(Schema::getColumnListing("$table") as $d => $value) {
                $output[$value] = null;
            }

            $output = json_encode($output);
            $output = json_decode($output);
        }

        return $output; 
    }

    public static function get_settings($name){
        $r = DB::select("SELECT * FROM settings WHERE name='$name'");
        $output = [];
        if(count($r) > 0){
            foreach ($r as $value) {
                $output = $value;
            }
        }
        else{
             foreach(Schema::getColumnListing("$table") as $d => $value) {
                $output[$value] = null;
            }
        }

        return $output; 
    }

    public static function select_query($query){
    	$r = DB::select($query);
        return $r; 
    }

    public static function calc_total_sales(){
        $total = 0;
        $q = DB::select("SELECT * FROM sales");
        foreach($q as $d){
            $total = $d->amount + $total;
        }

        return $total;
    }

    public static function calc_cost_price($sales_id){
        $drink_id = Site::get_record("sales", $sales_id)->drink_id;

        $total_cost = 0;
        $q = DB::select("SELECT * FROM drink_materials WHERE drink_id='$drink_id'");
        foreach($q as $d){
            $material_cost = Site::get_record("raw_materials", $d->material_id)->cost;

            $self_cost = $d->quantity * $material_cost;
            $total_cost = $self_cost + $total_cost;
        }

        return $total_cost;
       
    }

    public static function get_rent_drink_via_rd($rent_id, $drink_id){
        $r = DB::select("SELECT * FROM rent_drinks WHERE rent_id='$rent_id' AND drink_id='$drink_id'");
        $output = [];
        if(count($r) > 0){
            foreach ($r as $value) {
                $output = $value;
            }
        }
        else{
             foreach(Schema::getColumnListing("rent_drinks") as $d => $value) {
                $output[$value] = null;
            }
        }

        return $output; 
    }
}
