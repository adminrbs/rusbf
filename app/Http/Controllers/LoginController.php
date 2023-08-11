<?php

namespace App\Http\Controllers;
use Dotenv\Exception\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{



    public function loginForm(Request $request){

        $email = $request->txtEmail;
        $password = $request->txtPassword;

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // Authentication passed...

            $login_status = ["status" => "200", "redirect" => ""];
            return $login_status;

        } else {
            return "201";
        }

    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}



