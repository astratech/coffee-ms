<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;


class Card extends Controller{

	public function __construct() {
        $this->site_model = new Site;
    }

    
    public function enc($txt){

        echo $this->site_model->encode_password($txt);
    }

    public function dec($txt){

        echo $this->site_model->decode_password($txt);
    }
}
