<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberAttachment;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    public function view_member_form(){

        $designation_data = DB::table('master_designations') 
                                    ->select('id','name')
                                    ->where('status',1)
								    ->get();

        $works_data = DB::table('master_place_works') 
                                    ->select('id','name')
                                    ->where('status',1)
                                    ->get();
                                          
        $department_data = DB::table('master_sub_departments') 
                                ->select('id','name')
                                ->where('status',1)
                                ->get();
                                
        $payroll_data = DB::table('master_payrolls') 
                            ->select('id','name')
                            ->where('status',1)
                            ->get();

        $members = DB::table('members') 
                            ->select('id','name_initials','member_number')
                            ->get();
                
        return view('add_edit_member',compact('designation_data', 'works_data', 'department_data', 'payroll_data', 'members'));
    }

    public function save(Request $request){
        try {
            
            $file =  $request->file('file');
            $image_icon =  $request->get('imageIcon');
            $approvedBy = Auth::user()->id;
            $member = new Member();
           
            $member->prepared_by = $approvedBy;
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
            $member->member_email = $request->get('member_email');
            $member->member_whatsapp = $request->get('member_whatsapp');
            $member->beneficiary_email = $request->get('beneficiary_email');
            $member->beneficiary_nic = $request->get('beneficiary_nic');
            $member->ref_by = $request->get('ref_by');

            if ($member->save()) {

                if($file){
                    $this->uploadAttachment($file, $member->id);
                    
                    if($image_icon){
                        $this->uploadImageIcon($image_icon, $member->id);
                    }

                    return response()->json(["status" => "success", "file" => $file]);
                }else{
                    return response()->json(["status" => "without_img"]);
                }  
            }else{
                return response()->json(["status" => "failed"]);
            }

        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    private function uploadImageIcon($img, $name)
    {
        $folderPath = "attachments/member_icon_images/" . $name . ".png";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath;
        file_put_contents($file, $image_base64);

        return $file;
    }


    public function uploadAttachment($file, $id)
    {

        try{

            if ($file) {

                $exAttachment = MemberAttachment::where('member_id', $id)->first();
    
                if($exAttachment){

                    $ex_filepath = $exAttachment->path;

                    if($ex_filepath){
                        $baseUrl = url('/') . "/attachments/member_images/";
                        $file_data =  str_replace($baseUrl, '', $ex_filepath);
                        $file_data = public_path('attachments/member_images').'/'.$file_data;

                        if(file_exists($file_data)){
                            unlink($file_data);
                        }
                    }
                    
                    $file_name = $file->getClientOriginalName();
                    $filename = url('/') . '/attachments/member_images/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
                    $filename = str_replace(' ', '', str_replace('\'', '', $filename));
                    $file->move(public_path('attachments/member_images'), $filename);

                    $data = DB::table('member_attachments')
                                        ->where('member_id', $id)
                                        ->update(['path' => $filename]);
                    if($data){
                        $data = DB::table('members')
                                        ->where('id', $id)
                                        ->update(['path' => $filename]);
                    }
                    
                }else{
    
                    $file_name = $file->getClientOriginalName();
                    $filename = url('/') . '/attachments/member_images/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
                    $filename = str_replace(' ', '', str_replace('\'', '', $filename));
                    $file->move(public_path('attachments/member_images'), $filename);
    
                    $attachment = new MemberAttachment();
                    $attachment->member_id = $id;
                    $attachment->path = $filename;
                    $attachment->save();
    
                    $pathAttach = DB::table('members')
                                  ->where('id', $id)
                                  ->update(['path' => $filename]);
    
                }
            }

        }catch(Exception $ex){
            return $ex;
        }
    }


    public function get_all_members(){

        try {

            $all_members = DB::table("members")
                            ->select('members.computer_number','members.path','members.id','members.member_number','members.name_initials','members.national_id_number','members.mobile_phone_number')
                            ->get();

            return compact('all_members');

        }
         catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_member_data($id){
        
        try{
            $memberRequest = Member::where('id',$id)->first();

            $get_img_path = DB::table("member_attachments")
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
            $id = $request->input('id');
            $file =  $request->file('file');
            
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
            $member->member_email = $request->get('member_email');
            $member->member_whatsapp = $request->get('member_whatsapp');
            $member->beneficiary_email = $request->get('beneficiary_email');
            $member->beneficiary_nic = $request->get('beneficiary_nic');
            $member->ref_by = $request->get('ref_by');

            if ($member->save()) {

                if(isset($file)){
                    $this->uploadAttachment($file, $request->id);
                    return response()->json(["status" => "success", "file" => $file]);
                }else{

                    $exAttachment = MemberAttachment::where('member_id', $id)->first();
                    $ex_filepath = "";

                    if(isset($exAttachment->path)){
                        $ex_filepath =  $exAttachment->path;
                    }
                    $baseUrl = url('/') . "/attachments/member_images/";
                    $file_data =  str_replace($baseUrl, '', $ex_filepath);
                    $file_data = public_path('attachments/member_images').'/'.$file_data;

                    if(file_exists('attachments/member_images/'. $file_data)){
                        unlink($file_data);
                    }

                    $remove_att_records = DB::table("member_attachments")
                                                ->where('member_id', $id)
                                                ->delete();

                    $remove_mem_path = DB::table("members")
                                            ->select('members.path')
                                            ->where('id', $id)
                                            ->update(['path' => '']);

                    return response()->json(["status" => "without_img"]);
                }  
            }else{
                return response()->json(["status" => "failed"]);
            }

        }
         catch (Exception $ex) {
            return $ex;
        }
    }

    public function delete($id){

        try {

            $member = Member::where('id',$id)->first();
            $filePath = $member->path;

            if($filePath){
                $baseUrl = url('/') . "/attachments/member_images/";

                $file =  str_replace($baseUrl, '', $filePath);
                $file = public_path('attachments/member_images').'/'.$file;
    
                if(file_exists($file)){
                    unlink($file);
                }
    
                if($member->delete()){
                    $attachment = MemberAttachment::where('member_id',$id)->first();
                    $attachment->delete();
        
                    return "deleted";
                }else{
                    return "failed";
                }
            }else{
                $member->delete();
                return "deleted";
            }
            
        } catch (Exception $ex) {
            return $ex;
        }

    }

}
