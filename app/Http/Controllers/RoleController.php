<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleController extends Controller
{
    
    public function save_user_role(Request $request){
        
        try{
            $role = new Role();
            $role->name = $request->get('role_name');
            
            if($role->save()){
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

            $data = DB::table("roles")
                            ->select('roles.id','roles.name','roles.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_role_data($id){

        try{

            $data = DB::table("roles")
                            ->select('roles.name')
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
            $role = Role::find($id);
    
            $role->name = $request->get('role_name');
            
            if($role->update()){
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

            $isUsed = UserRole::where('role_id', $id)->exists();

            if($isUsed){
                return response()->json(["status" => "role_used"]);
            }else{
                $role = Role::where('id', $id)->first();

                if ($role->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }
            }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function user_role_status(Request $request, $id){
        try{
            $role = Role::findOrFail($id);
            $role->status = $request->get('status');
          
            if($role->save()){
                return response()->json(["status" => "saved"]);
            }else{
                return response()->json(["status" => "failed"]);
            }
            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    } 

}
