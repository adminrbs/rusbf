<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\members_loan_request;
use App\Models\members_loan_request_attachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembersLoanRequestController extends Controller
{
    public function memberShip()
    {
        try {
            $member = Member::all();
            if ($member) {
                return response()->json((['success' => 'Data loaded', 'data' => $member]));
            } else {
                return response()->json((['error' => 'Data is not loaded']));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function save_memberlonrequest(Request $request)
    {

        try {
            $approvedBy = Auth::user()->id;
            $memberlon = new members_loan_request();
            $memberlon->prepared_by = $approvedBy;
            $memberlon->membership_no  = $request->get('txtmembershipno');
            $memberlon->contact_no  = $request->get('txtcontactno');
            $memberlon->service_period  = $request->get('txtpriodofservice');

            $memberlon->date_of_enlistment  = $request->get('txtdateofenlistment');
            $memberlon->Monthly_basic_salary  = $request->get('txtpresetmonthlybSalary');
            $memberlon->computer_no  = $request->get('txtcomputerno');

            $memberlon->nic_no  = $request->get('txtnicNo2');
            $memberlon->manner_of_repayment  = $request->get('txtManageofrepayment');
            $memberlon->reason  = $request->get('txtresontoobtain');

            $memberlon->private_address  = $request->get('txtprivetAddress');
            $memberlon->date  = $request->get('txtdate');





            if ($memberlon->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function allmemberlonrequest()
    {
        try {
            $members_loan = 'SELECT * FROM members_loan_requests mlr WHERE mlr.approval_status="Rejected" ||  mlr.approval_status="Approved"';
            
               
                $result = DB::select($members_loan);
                if ($result) {
                    return response()->json((['success' => 'Data loaded', 'data' => $result]));
                } else {
                    return response()->json((['error' => 'Data is not loaded','data' => []]));
                }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getmemberlone($id)
    {
        try {
            $members_loan = members_loan_request::find($id);

            //dd($supplygroup);
            return response()->json($members_loan);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update_memberlonrequest(Request $request, $id)
    {
        try {

            $memberlon = members_loan_request::find($id);
            $memberlon->membership_no  = $request->get('txtmembershipno');
            $memberlon->contact_no  = $request->get('txtcontactno');
            $memberlon->service_period  = $request->get('txtpriodofservice');

            $memberlon->date_of_enlistment  = $request->get('txtdateofenlistment');
            $memberlon->Monthly_basic_salary  = $request->get('txtpresetmonthlybSalary');
            $memberlon->computer_no  = $request->get('txtcomputerno');

            $memberlon->nic_no  = $request->get('txtnicNo2');
            $memberlon->manner_of_repayment  = $request->get('txtManageofrepayment');
            $memberlon->reason  = $request->get('txtresontoobtain');

            $memberlon->private_address  = $request->get('txtprivetAddress');
            $memberlon->date  = $request->get('txtdate');


            if ($memberlon->update()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    //save Attachment

    public function saveattachment(Request $request, $id)
    {
        try {

            $file = $request->file('file');

            $attachment = new members_loan_request_attachment();
            $attachment->description = $request->get('txtDescription');
            $attachment->members_loan_request_id = $id;
            if ($attachment->save()) {
                if ($file) {

                    $this->uploadAttachment($file, $attachment->members_loan_request_attachment_id);
                }
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function uploadAttachment($file, $id)
    {



        try {
            $exAttachment = members_loan_request_attachment::where('members_loan_request_attachment_id', $id)->first();

            if ($exAttachment) {

                $ex_filepath = $exAttachment->attachment;

                if ($ex_filepath) {
                    $baseUrl = url('/') . "/attachments/member_lone_request_file/";
                    $file_data =  str_replace($baseUrl, '', $ex_filepath);
                    $file_data = public_path('attachments/member_lone_request_file') . '/' . $file_data;

                    if (file_exists($file_data)) {
                        unlink($file_data);
                    }
                }

                $file_name = $file->getClientOriginalName();
                $filename = url('/') . '/attachments/member_lone_request_file/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
                $filename = str_replace(' ', '', str_replace('\'', '', $filename));
                $file->move(public_path('attachments/member_lone_request_file'), $filename);

                $data = DB::table('members_loan_request_attachments')
                    ->where('members_loan_request_attachment_id', $id)
                    ->update(['attachment' => $filename]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }





    public function deletememberlone($id)
    {
        try {
            $memberlon = members_loan_request::find($id);

            $memberlon->delete();
            return response()->json(['success' => 'Record has been Delete']);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    public function getalldetails($id)
    {

        try {
            $query = 'SELECT *,md.name,mpw.name AS plase FROM members
       INNER JOIN master_designations md ON md.id=members.designation_id
       INNER JOIN master_place_works mpw ON mpw.id=members.work_location_id
       WHERE members.id= "' . $id . '"';



            $Member = DB::select($query);

            return response()->json($Member);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    //approve request
    public function approveRequest($id)
    {

        try {
            $request = members_loan_request::find($id);
            $request->approval_status = "Approved";
            //$request->approved_by = $approvedBy;
            if ($request->update()) {
                return response()->json((['status' => true]));
            } else {
                return response()->json((['status' => false]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    //reject request
    public function rejectRequest($id)
    {

        try {
            $request = members_loan_request::find($id);
            $request->approval_status = "Rejected";
            //$request->approved_by = $approvedBy;
            if ($request->update()) {
                return response()->json((['status' => true]));
            } else {
                return response()->json((['status' => false]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function getAttachment($id)
    {

        try {

            $query = 'SELECT * FROM members_loan_request_attachments WHERE members_loan_request_attachments.members_loan_request_id="' . $id . '"';
            $attachment = DB::select($query);

            return response()->json($attachment);
        } catch (Exception $ex) {
            return $ex;
        }
    }

public function viewAttachment($id){
try{
    $request = members_loan_request_attachment::find($id);
    return response()->json($request);
}catch(Exception $ex){
    return $ex;
}

}

public function deletattachment($id)
{
    try {
        $request = members_loan_request_attachment::find($id);
    
        $request->delete();
        return response()->json(['success' => 'Record has been Delete']);
    } catch (Exception $ex) {
        return response()->json($ex);
    }
}

public function allmemberlonrequestapprovel(){
    try {
        $query = 'SELECT * FROM members_loan_requests mlr WHERE mlr.approval_status="pending"';
        /* $pendingApprovals = purchase_request::where("approval_status","=","Pending")->get(); */
        $pendingApprovals = DB::select($query);
        if ($pendingApprovals) {
            return response()->json((['success' => 'Data loaded', 'data' => $pendingApprovals]));
        } else {
            return response()->json((['error' => 'Data not loaded', 'data' => []]));
        }
    } catch (Exception $ex) {
        return $ex;
    }
}
}
