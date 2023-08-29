<?php

namespace App\Http\Controllers;

use App\Models\MasterPayroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Member;

class MasterPayrollController extends Controller
{


    public function save_payroll(Request $request){
        
        try{
            $payroll = new MasterPayroll();
            $payroll->name = $request->get('name');
            
            if($payroll->save()){
                return response()->json(["status" => "succeed"]);
            }else{
                return response()->json(["status" => "failed"]);
            }

        }catch(Exception $ex){
            return $ex->getMessage();
        }

    }


    public function get_all_payroll(){

        try {

            $data = DB::table("master_payrolls")
                            ->select('master_payrolls.id','master_payrolls.name','master_payrolls.status')
                            ->get();

            return compact('data');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_payroll_data($id){

        try{

            $data = DB::table("master_payrolls")
                            ->select('master_payrolls.name')
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
            $payroll = MasterPayroll::find($id);
    
            $payroll->name = $request->get('name');
            
            if($payroll->update()){
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
            $isUsed = Member::where('payroll_preparation_location_id', $id)->exists();
            $getone = MasterPayroll::where('id', 1)->exists();

            if ($isUsed) {
                
                return response()->json(["status" => "payroll_used"]);

            }elseif($getone){
                return response()->json(["status" => "cannot"]);
            }else{

                $payroll = MasterPayroll::where('id', $id)->first();

                if ($payroll->delete()) {
                    return response()->json(["status" => "deleted"]);
                } else {
                    return response()->json(["status" => "failed"]);
                }

            }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function payrollStatus(Request $request, $id){
        try{
            $payroll = MasterPayroll::findOrFail($id);
            $payroll->status = $request->get('status');
          
            if($payroll->save()){
                return response()->json(["status" => "saved"]);
            }else{
                return response()->json(["status" => "failed"]);
            }
            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }  
}
