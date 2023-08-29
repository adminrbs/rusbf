<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UserRoleController extends Controller
{
    
    public function save_user_role(Request $request){
        
        try{
            $user_role = new UserRole();
            $user_role->name = $request->get('role_name');
            
            if($user_role->save()){
                return response()->json(["status" => "succeed"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }

    public function get_user_roles(){

        try {

            $data = DB::table("user_roles")
                            ->select('user_roles.id','user_roles.name','user_roles.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_role_data($id){

        try{

            $data = DB::table("user_roles")
                            ->select('user_roles.name')
                            ->where('id',$id)
                            ->first();

            return compact('data');

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }


    public function update(Request $request)
    {
        try{
            $id = $request->input('id');
            $user_role = UserRole::find($id);
    
            $user_role->name = $request->get('role_name');
            
            if($user_role->update()){
                return response()->json(["status" => "updated"]);
            }else{
                return response()->json(["status" => "failed"]);
            }
        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }

    public function delete($id){
        try {
            $user_role = UserRole::where('id', $id)->first();

                if ($user_role->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function user_role_status(Request $request, $id){
        try{
            $user_role = UserRole::findOrFail($id);
            $user_role->status = $request->get('status');
          
            if($user_role->save()){
                return response()->json(["status" => "saved"]);
            }else{
                return response()->json(["status" => "failed"]);
            }
            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    } 

}
