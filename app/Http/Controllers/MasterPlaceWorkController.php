<?php

namespace App\Http\Controllers;

use App\Models\MasterPlaceWork;
use Illuminate\Http\Request;
use App\Models\Member;
use Exception;
use DB;

class MasterPlaceWorkController extends Controller
{
    
    public function save_place_of_work(Request $request){
        
        try{
            $placework = new MasterPlaceWork();
            $placework->name = $request->get('name');
            
            if($placework->save()){
                return response()->json(["status" => "succeed"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }

    public function get_all_place_of_work(){

        try {

            $data = DB::table("master_place_works")
                            ->select('master_place_works.id','master_place_works.name','master_place_works.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function get_place_of_work_data($id){

        try{

            $data = DB::table("master_place_works")
                            ->select('master_place_works.name')
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
            $placework = MasterPlaceWork::find($id);
    
            $placework->name = $request->get('name');
            
            if($placework->update()){
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
            $isUsed = Member::where('work_location_id', $id)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "work_place_used"]);

            }elseif($id == 1){
                return response()->json(["status" => "cannot"]);
            }else{

                $placework = MasterPlaceWork::where('id', $id)->first();

                if ($placework->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }

            }

        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function place_of_workStatus(Request $request, $id){
        try{
            $placework = MasterPlaceWork::findOrFail($id);
            $placework->status = $request->get('status');
          
            if($placework->save()){
                return response()->json(["status" => "saved"]);
            }else{
                return response()->json(["status" => "failed"]);
            }
            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }   


}
