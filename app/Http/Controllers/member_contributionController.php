<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\member_contribution;
use App\Models\MemberAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\contribution;
use App\Models\GlobalSetting;
use App\Models\loan;
use App\Models\MasterSubDepartment;
use App\Models\MemberContributionLedger;
use App\Models\MemberLoanLedger;

class member_contributionController extends Controller
{

    public function membercontributedata($id)
    {
        try {

            if ($id == 0) {


                $contribution = contribution::all();
                if ($contribution) {
                    return response()->json((['success' => 'Data loaded', 'data' => $contribution]));
                } else {
                    return response()->json((['error' => 'Data is not loaded']));
                }
            } else {
                $query = "SELECT c.contribution_id, c.contribution_code, c.contribution_title,IF(ISNULL(mc.amount),c.amount,mc.amount)AS amount, mc.member_id
                FROM contributions c
                LEFT JOIN member_contributions mc ON c.contribution_id = mc.contributions_id AND mc.member_id= $id";

                $contribution = DB::select($query);
                //dd($contribution);

                return response()->json((['success' => 'Data loaded', 'data' => $contribution]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function memberNumber($dept_id)
    {
        if ($dept_id > 0) {
            $filteredMember =  Member::where('id', $dept_id)->get();

          
            if ($filteredMember) {
              
                $unfilteredMembers = Member::where('id', '<>', $dept_id)->get();
        
                $members = $filteredMember->toBase()->merge($unfilteredMembers);
                return response()->json($members);
            } else {
               
                return response()->json(['error' => 'Member not found'], 404);
            }
            // $members = Member::where('id', $dept_id)->get();
            // return response()->json($members);
        } else {
            $members = Member::all();
            return response()->json($members);
        }
    }




    public function computerNumber($dept_id)
    {

        $members = Member::all();
        return response()->json($members);
    }

    public function member_subdepartment()
    {
        $query = "SELECT master_sub_departments.`name`,members.id
        FROM master_sub_departments INNER JOIN members ON master_sub_departments.id = members.id";
        $departments = DB::select($query);
        return response()->json($departments);
    }

    public function fullName($dept_id)
    {
        $members = Member::all();
        return response()->json($members);
    }

    public function imageloard($id)
    {
        try {
            if ($id == 0) {
                $Member = MemberAttachment::all();

                return response()->json($Member);
            } else {
                $Member = MemberAttachment::where('member_id', '=', $id)->first();

                return response()->json($Member);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function save_memberContribution(Request $request)
    {

        try {
            $collection = json_decode($request->get('data'));

            member_contribution::where([['member_id', '=', $request->get('cmbmember')]])->delete();

            foreach ($collection as $data) {
                $array = json_decode($data);
                $contribution = new member_contribution();
                $contribution->member_id  = $request->get('cmbmember');
                if ($array->amount) {
                    $contribution->amount  = $array->amount;
                } else {
                    $contribution->amount  = 0;
                }
                $contribution->contributions_id =  $array->contribution_id;
                $contribution->save();
            }

            return response()->json(['status' => true]);
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function deleteMembercontribution(Request $request, $id)
    {

        try {

            $member_id = $request->input('member_id');
            /* if ($member_id != null  && $id != null) {
                $deletedRows = member_contribution::where('contributions_id', $id && 'member_id', $member_id);
                $deletedRows->delete();
                return response()->json(['success' => 'Record has been deleted']);
            } else {
                return response()->json(['error' => 'Record not found or already deleted'], 404);
            }*/

            $deletedRows = DB::delete("DELETE FROM member_contributions WHERE contributions_id = :id AND member_id = :member_id", [
                'id' => $id,
                'member_id' => $member_id,
            ]);

            if ($deletedRows > 0) {
                // Successfully deleted at least one record
                return response()->json(['success' => 'Member contribution deleted successfully']);
            } else {
                // No matching records found for deletion
                return response()->json(['error' => 'No matching records found for deletion']);
            }




            /* $deletedRows = member_contribution::where('contributions_id', $id)
            ->where('member_id', $member_id)
            ->delete();*/
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }
    public function amountset($id)
    {
        try {
            $Member = member_contribution::where('member_id', '=', $id)->get();
            return response()->json($Member);
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function loadContribution($year, $month, $member_id)
    {
        try {
            $contributions = MemberContributionLedger::where('member_id', '=', $member_id)->get();
            if ($year == 'any' && $month != 'any') {
                $contributions = MemberContributionLedger::where([['member_id', '=', $member_id], ['month', '=', $month]])->get();
            } else  if ($year != 'any' && $month == 'any') {
                $contributions = MemberContributionLedger::where([['member_id', '=', $member_id], ['year', '=', $year]])->get();
            } else  if ($year != 'any' && $month != 'any') {
                $contributions = MemberContributionLedger::where([['member_id', '=', $member_id], ['year', '=', $year], ['month', '=', $month]])->get();
            }

            foreach ($contributions as $contribution_data) {
                $contribution_data->contribution_name = "";
                $contribution = contribution::find($contribution_data->contribution_id);
                if ($contribution) {
                    $contribution_data->contribution_name = $contribution->contribution_title;
                }
            }
            return response()->json(["status" => true, "data" => $contributions]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }



    public function loadLoan($year, $month, $member_id)
    {
        try {
            $loans = MemberLoanLedger::where('member_id', '=', $member_id)->get();
            if ($year == 'any' && $month != 'any') {
                $loans = MemberLoanLedger::where([['member_id', '=', $member_id], ['month', '=', $month]])->get();
            } else  if ($year != 'any' && $month == 'any') {
                $loans = MemberLoanLedger::where([['member_id', '=', $member_id], ['year', '=', $year]])->get();
            } else  if ($year != 'any' && $month != 'any') {
                $loans = MemberLoanLedger::where([['member_id', '=', $member_id], ['year', '=', $year], ['month', '=', $month]])->get();
            }

            foreach ($loans as $loan_data) {
                $loan_data->loan_name = "";
                $loan = loan::find($loan_data->member_loan_id);
                if ($loan) {
                    $loan_data->loan_name = $loan->loan_name;
                }
            }
            return response()->json(["status" => true, "data" => $loans]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }


    public function getGlobalYearMonth()
    {
        try {
            $year = "any";
            $month = "any";
            $global_setting = GlobalSetting::find(1);
            if ($global_setting) {
                $year = $global_setting->current_year;
                $month = $global_setting->current_month;
            }
            return response()->json(["status" => true, "year" => $year, "month" => $month]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }


    public function saveLoan(Request $request)
    {
        try {
            $collection = json_decode($request->get('data'));
            foreach ($collection as $data) {
                $id = json_decode($data)->id;
                $value1 = json_decode($data)->value1;
                $value2 = json_decode($data)->value2;

                $loan_ledger = MemberLoanLedger::find($id);
                if ($loan_ledger) {
                    $loan_ledger->paid_amount = $value1;
                    $loan_ledger->paid_interest = $value2;

                    if (!$loan_ledger->update()) {
                        return response()->json(["status" => false, "error" => 204]);
                    }
                }
            }
            return response()->json(["status" => true]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }



    public function saveContribution(Request $request)
    {
        try {
            $collection = json_decode($request->get('data'));
            foreach ($collection as $data) {
                $id = json_decode($data)->id;
                $value = json_decode($data)->value;
                $contribution_ledger = MemberContributionLedger::find($id);
                if ($contribution_ledger) {
                    $contribution_ledger->paid_amount = $value;
                    if (!$contribution_ledger->update()) {
                        return response()->json(["status" => false, "error" => 204]);
                    }
                }
            }
            return response()->json(["status" => true]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }


    public function next($dept_id, $member_id)
    {
        try {
            $query = "SELECT id  From  members  
            WHERE serving_sub_department_id='" . $dept_id . "'  AND id>'" . $member_id . "'
            ORDER BY id ASC  LIMIT 1";
            $result = DB::select($query);
            $id = 0;
            if (count($result) > 0) {
                $id = $result[0]->id;
            }
            return response()->json(["status" => true, "data" => $id]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }


    public function previous($dept_id, $member_id)
    {
        try {
            $query = "SELECT id  From  members  
            WHERE serving_sub_department_id='" . $dept_id . "'  AND id<'" . $member_id . "'
            ORDER BY id DESC  LIMIT 1";
            $result = DB::select($query);
            $id = 1;
            if (count($result) > 0) {
                $id = $result[0]->id;
            }
            return response()->json(["status" => true, "data" => $id]);
        } catch (Exception $ex) {
            return response()->json(["status" => false, "error" => $ex]);
        }
    }
}
