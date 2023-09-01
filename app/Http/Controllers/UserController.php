<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Exception;
use DB;

class UserController extends Controller
{

    public function view_user(){

        $role_data = DB::table('roles') 
                        ->select('id','name')
                        ->get();

        return view('view_user_create',compact('role_data'));
    }

    public function save_user(Request $request){

        try{
            $user = new User();
            $user->name = $request->get('username');
            $user->email = $request->get('email');
            $user->user_type = ($request->get('usertype') == 0) ? 'Guest' : 'Employee';
    
            $user->password = Hash::make($request->get('password'));
    
            if($user->save()){
                $user_role = new UserRole();
                $user_role->user_id = $user->id;
                $user_role->role_id = $request->get('userrole');
                $user_role->save();
    
                return response()->json(["status" => "saved"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex;
        }

    }
}
