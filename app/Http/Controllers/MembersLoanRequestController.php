<?php

namespace App\Http\Controllers;

use App\Models\loan;
use App\Models\loan_term;
use App\Models\Member;
use App\Models\member_loan;
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
    public function getlone()
    {
        try {
            $loan = loan::all();
            if ($loan) {
                return response()->json((['success' => 'Data loaded', 'data' => $loan]));
            } else {
                return response()->json((['error' => 'Data is not loaded']));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
    public function getterm($id)
    {
        try {
            $query = "SELECT loan_terms.loan_term_id,loan_terms.no_of_terms FROM loan_terms WHERE loan_terms.loan_id=$id";
            $term = DB::select($query);


            if ($term) {
                return response()->json($term);
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
            $member = $request->get('txtmembershipno');
            $memberno = Member::find($member);



            $approvedBy = Auth::user()->id;
            $memberlon = new members_loan_request();
            $memberlon->prepared_by = $approvedBy;
            $memberlon->member_id  = $request->get('txtmembershipno');
            $memberlon->membership_no = $memberno->member_number;
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

            $memberlon->loan_id  = $request->get('cbxlone');
            $memberlon->term_id  = $request->get('cbxloneterm');

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
            $members_loan = 'SELECT * FROM members_loan_requests mlr ORDER BY approval_status ASC';


            $result = DB::select($members_loan);
            if ($result) {
                return response()->json((['success' => 'Data loaded', 'data' => $result]));
            } else {
                return response()->json((['error' => 'Data is not loaded', 'data' => []]));
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
            $member = $request->get('txtmembershipno');
            $memberno = Member::find($member);

            $memberlon = members_loan_request::find($id);
            $memberlon->member_id  = $request->get('txtmembershipno');
            $memberlon->contact_no  = $request->get('txtcontactno');
            $memberlon->membership_no = $memberno->member_number;
            $memberlon->service_period  = $request->get('txtpriodofservice');

            $memberlon->date_of_enlistment  = $request->get('txtdateofenlistment');
            $memberlon->Monthly_basic_salary  = $request->get('txtpresetmonthlybSalary');
            $memberlon->computer_no  = $request->get('txtcomputerno');

            $memberlon->nic_no  = $request->get('txtnicNo2');
            $memberlon->manner_of_repayment  = $request->get('txtManageofrepayment');
            $memberlon->reason  = $request->get('txtresontoobtain');

            $memberlon->private_address  = $request->get('txtprivetAddress');
            $memberlon->date  = $request->get('txtdate');
            $memberlon->loan_id  = $request->get('cbxlone');
            $memberlon->term_id  = $request->get('cbxloneterm');


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

    public function getalldetails($memberid, $id)
    {

        try {
            $query = 'SELECT members.*, md.name AS designation, mpw.name AS work_location
            FROM members
            INNER JOIN master_designations md ON md.id = members.designation_id
            INNER JOIN master_place_works mpw ON mpw.id = members.work_location_id';

            switch ($id) {
                case 1:
                    $query .= ' WHERE members.id = ' . $memberid;
                    break;
                case 2:
                    $query .= ' WHERE members.national_id_number = ' . $memberid;
                    break;
                case 3:
                    $query .= ' WHERE members.computer_number = ' . $memberid;
                    break;
                case 4:
                    $query .= " WHERE members.date_of_joining = '$memberid'";
                    break;
                default:
                    // Handle invalid $id if necessary
                    break;
            }

            $result = DB::select($query);
            //dd($result);
            return response()->json($result);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    //approve request
    public function approveRequest(Request $request, $id)
    {

        try {
            $memberterm = $request->get('cbxloneterm');


            $memberlonrequest = members_loan_request::find($id);
            $memberlonrequest->approval_status = 1;
            //$request->approved_by = $approvedBy;
            if ($memberlonrequest->update()) {
                if ($memberterm) {
                    $loanandterm = "SELECT *,loans.amount FROM loan_terms lt 
                    INNER JOIN loans ON loans.loan_id=lt.loan_id
                    WHERE lt.loan_term_id=  $memberterm";
                    $loneterm = DB::select($loanandterm);


                    if (!empty($loneterm)) {
                        $loneterm = $loneterm[0];

                        $memberlon = new member_loan();
                        $memberlon->member_id  = $request->get('txtmembershipno');
                        $memberlon->loan_id  = $request->get('cbxlone');
                        $memberlon->loan_term_id  = $request->get('cbxloneterm');

                        $memberlon->no_of_terms = $loneterm->no_of_terms;
                        $memberlon->term_amount = $loneterm->term_amount;
                        $memberlon->term_interest_amount = $loneterm->term_interest_amount;
                        $memberlon->term_interest_precentage = $loneterm->term_interest_precentage;
                        $memberlon->loan_amount = $loneterm->amount;
                        if ($memberlon->save()) {
                            return response()->json((['status' => true]));
                        } else {
                            return response()->json((['status' => false]));
                        }
                    }
                }
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
            $request->approval_status = 2;
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

    public function viewAttachment($id)
    {
        try {
            $request = members_loan_request_attachment::find($id);
            return response()->json($request);
        } catch (Exception $ex) {
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

    public function allmemberlonrequestapprovel()
    {
        try {
            $query = 'SELECT * FROM members_loan_requests mlr WHERE mlr.approval_status="0"';
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
