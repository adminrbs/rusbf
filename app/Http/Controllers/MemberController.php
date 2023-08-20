<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberAttachment;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    public function save(Request $request){
        try {
            
            $file =  $request->file('file');
            $member = new Member();

            $member->beneficiary_full_name = $request->get('beneficiary_full_name');
            $member->beneficiary_private_address = $request->get('beneficiary_private_address');
            $member->beneficiary_relationship = $request->get('beneficiary_relationship');
            $member->cabinet_number = $request->get('cabinet_number');
            $member->computer_number = $request->get('computer_number');
            $member->date_of_birth = $request->get('date_of_birth');
            $member->date_of_joining = $request->get('date_of_joining');
            $member->designation_id = $request->get('designation_id');
            $member->full_name = $request->get('full_name');
            $member->full_name_unicode = $request->get('full_name_unicode');
            $member->home_phone_number = $request->get('home_phone_number');
            $member->language_id = $request->get('language_id');
            $member->member_number = $request->get('member_number');
            $member->mobile_phone_number = $request->get('mobile_phone_number');
            $member->monthly_payment_amount = $request->get('monthly_payment_amount');
            $member->name_initials = $request->get('name_initials');
            $member->name_initials_unicode = $request->get('name_initials_unicode');
            $member->national_id_number = $request->get('national_id_number');
            $member->official_number = $request->get('official_number');
            $member->payroll_number = $request->get('payroll_number');
            $member->payroll_preparation_location_id = $request->get('payroll_preparation_location_id');
            $member->personal_address = $request->get('personal_address');
            $member->serving_sub_department_id = $request->get('serving_sub_department_id');
            $member->work_location_id = $request->get('work_location_id');

            if ($member->save()) {
                $this->uploadAttachment($file, $member->id);
                return response()->json(["status" => true, "file" => $file]);
            }
            return response()->json(["status" => false]);

        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    public function uploadAttachment($file, $id)
    {

        if ($file) {
            $file_name = $file->getClientOriginalName();
            $filename = url('/') . '/member_images/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
            $filename = str_replace(' ', '', str_replace('\'', '', $filename));
            $file->move(public_path('member_images'), $filename);

            $exAttatchment = MemberAttachment::find($id);

            if($exAttatchment){
                $exAttatchment->path = $filename;
                $exAttatchment->save();

                $pathAttach = DB::table('limitless_laravel.members')
                              ->where('id', $id)
                              ->update(['path' => $filename]);

            }else{

                $attachment = new MemberAttachment();
                $attachment->member_id = $id;
                $attachment->path = $filename;
                $attachment->save();

                $pathAttach = DB::table('limitless_laravel.members')
                              ->where('id', $id)
                              ->update(['path' => $filename]);

            }

        }
    }

    public function get_all_members(){

        try {

            $all_members = DB::table("limitless_laravel.members")
                            ->select('members.path','members.id','members.member_number','members.name_initials','members.national_id_number','members.mobile_phone_number')
                            ->get();

            return compact('all_members');

        }
         catch (Exception $exception) {
            return $ex->getMessage();
        }
    }

    public function get_member_data($id){
        
        try{
            $memberRequest = Member::where('id',$id)->first();
            // dd($memberRequest);
            $get_img_path = DB::table("limitless_laravel.member_attachments")
                                ->select('member_attachments.path')
                                ->where('member_id', $id)
                                ->first();

                                
            if($get_img_path == null){
                $path = 'not_available';
            }else{
                $path = $get_img_path->path;
            }

            return [$memberRequest, $path];

        }catch(Exception $ex) {
            return $ex->getMessage();
        }
    }
       

    public function update(Request $request){
        
        try {
            $member =Member::find($request->id);
            $member->beneficiary_full_name = $request->get('beneficiary_full_name');
            $member->beneficiary_private_address = $request->get('beneficiary_private_address');
            $member->beneficiary_relationship = $request->get('beneficiary_relationship');
            $member->cabinet_number = $request->get('cabinet_number');
            $member->computer_number = $request->get('computer_number');
            $member->date_of_birth = $request->get('date_of_birth');
            $member->date_of_joining = $request->get('date_of_joining');
            $member->designation_id = $request->get('designation_id');
            $member->full_name = $request->get('full_name');
            $member->full_name_unicode = $request->get('full_name_unicode');
            $member->home_phone_number = $request->get('home_phone_number');
            $member->language_id = $request->get('language_id');
            $member->member_number = $request->get('member_number');
            $member->mobile_phone_number = $request->get('mobile_phone_number');
            $member->monthly_payment_amount = $request->get('monthly_payment_amount');
            $member->name_initials = $request->get('name_initials');
            $member->name_initials_unicode = $request->get('name_initials_unicode');
            $member->national_id_number = $request->get('national_id_number');
            $member->official_number = $request->get('official_number');
            $member->payroll_number = $request->get('payroll_number');
            $member->payroll_preparation_location_id = $request->get('payroll_preparation_location_id');
            $member->personal_address = $request->get('personal_address');
            $member->serving_sub_department_id = $request->get('serving_sub_department_id');
            $member->work_location_id = $request->get('work_location_id');
            
            $member->save();
            return "true";

            // if ($member->save()) {
            //     $this->uploadAttachment($file, $request->id);
            //     return response()->json(["status" => true, "file" => $file]);
            // }
            // return response()->json(["status" => false]);

        }
         catch (Exception $exception) {
            return $ex->getMessage();
        }
    }

    public function delete($id){

        try {

            $member = Member::where('id',$id)->first();
            $filePath = $member->path;
            $baseUrl = "http://127.0.0.1:8000/member_images/";

            $file =  str_replace($baseUrl, '', $filePath);
            $file = public_path('member_images').'/'.$file;

            if(file_exists($file)){
                unlink($file);
            }
            $member->delete();

            $attachment = MemberAttachment::where('id',$id)->first();
            $attachment->delete();

            return "deleted";
            
        } catch (Exception $exception) {
            return $ex->getMessage();
        }

    }

}
