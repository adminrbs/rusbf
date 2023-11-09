<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyDetailsController extends Controller
{
    
    public static function CompanyName(){
        return "EasywinBiz LMS"; 
    }

    public static function CompanyNumber(){
        return "Tel : 0314874344 Fax : 0314874347";  
    }
    public static function CompanyAddress(){
        return "NO 14,1 ST CROSS STREET,NEGOMBO";  
    }
    public static function companyimage(){

    return "images/login_logo copy.png";
    }
    

}
