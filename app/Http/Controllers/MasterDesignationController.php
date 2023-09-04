<?php

namespace App\Http\Controllers;

use App\Models\MasterDesignation;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MasterDesignationController extends Controller
{

    public function save_designation(Request $request){
        
        try{
            $designation = new MasterDesignation();
            $designation->name = $request->get('name');
            
            if($designation->save()){
                return response()->json(["status" => "succeed"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }

    public function get_all_designations(){

        try {

            $data = DB::table("master_designations")
                            ->select('master_designations.id','master_designations.name','master_designations.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_designation_data($id){

        try{

            $data = DB::table("master_designations")
                            ->select('master_designations.name')
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
            $designation = MasterDesignation::find($id);
    
            $designation->name = $request->get('name');
            
            if($designation->update()){
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
            $isUsed = Member::where('designation_id', $id)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "designation_used"]);

            }elseif($id == 1){
                return response()->json(["status" => "cannot"]);
            }else{

                $designation = MasterDesignation::where('id', $id)->first();

                if ($designation->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }

            }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function designationStatus(Request $request, $id){
        try{

            $isUsed = Member::where('designation_id', $id)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "used"]);

            }else{

                $designation = MasterDesignation::findOrFail($id);
                $designation->status = $request->get('status');
                
                if($designation->save()){
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
