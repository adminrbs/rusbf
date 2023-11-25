<?php

namespace App\Http\Controllers;

use App\Models\MasterSubDepartment;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Exception;

class MasterSubDepartmentController extends Controller
{
    
    public function save_department(Request $request){
        
        try{
            $department = new MasterSubDepartment();
            $department->name = $request->get('name');
            $department->code = $request->get('sub_department_code');
            
            if($department->save()){
                return response()->json(["status" => "succeed"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }

    public function get_all_departments(){

        try {

            $data = DB::table("master_sub_departments")
                            ->select('master_sub_departments.id','master_sub_departments.name','master_sub_departments.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function get_department_data($id){

        try{

            $data = DB::table("master_sub_departments")
                            ->select('master_sub_departments.name,master_sub_departments.code')
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
            $department = MasterSubDepartment::find($id);
    
            $department->name = $request->get('name');
            $department->code = $request->get('sub_department_code');
            if($department->update()){
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
            $isUsed = Member::where('serving_sub_department_id', $id)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "department_used"]);

            }elseif($id == 1){
                return response()->json(["status" => "cannot"]);
            }else{

                $department = MasterSubDepartment::where('id', $id)->first();

                if ($department->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }

            }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function departmentStatus(Request $request, $id){
        try{

            $isUsed = Member::where('serving_sub_department_id', $id)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "used"]);

            }else{
                
                $department = MasterSubDepartment::findOrFail($id);
                $department->status = $request->get('status');
            
                if($department->save()){
                    return response()->json(["status" => "saved"]);
                }else{
                    return response()->json(["status" => "failed"]);
                }

            }
            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }   


}
