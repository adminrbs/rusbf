<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\contribution;
use App\Models\loan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class contributionandLoanFilterController extends Controller
{
    public function getmember()
    {
        try {
            $members = Member::all();
            return response()->json($members);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function subdepartment($id)
    {
        try {
            if ($id == 0) {
                $query = "SELECT * FROM master_sub_departments";

                $Member = DB::select($query);
                return response()->json($Member);
            } else {
                $query = 'SELECT MSD.id, MSD.name
                FROM master_sub_departments MSD
                LEFT JOIN members M ON MSD.id = M.serving_sub_department_id
                GROUP BY MSD.id, MSD.name
                ORDER BY MAX(M.id = '.$id.') DESC';

                $Member = DB::select($query);
                if ($Member) {

                    return response()->json($Member);
                } else {
                    return response()->json(['status' => false]);
                }
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function getcontribution(Request $request, $id)
    {
        /* try {
                $contribution = contribution::all();
                return response()->json($contribution);
            } catch (Exception $ex) {
                return $ex;
            }*/
        try {
            $year = $request->input('cmb_year');
            $month = $request->input('cmb_month');


            if ($id == 0) {
                if ($year == "any" && $month == "any") {

                    $query = "SELECT mcl.member_contribution_ledger_id,mcl.member_id,C.contribution_id,C.contribution_code,C.contribution_title,C.amount
                    FROM member_contribution_ledgers mcl
                    LEFT JOIN members M ON mcl.member_id=M.id
                    LEFT JOIN contributions C ON C.contribution_id=mcl.contribution_id";
                    $members = DB::select($query);
                    return response()->json(['data' => $members,]);
                } else {

                    $query = "SELECT mcl.member_contribution_ledger_id,mcl.member_id,C.contribution_id,C.contribution_code,C.contribution_title,C.amount
                    FROM member_contribution_ledgers mcl
                    LEFT JOIN members M ON mcl.member_id=M.id
                    LEFT JOIN contributions C ON C.contribution_id=mcl.contribution_id";
                    $conditions = array();

                    if (!empty($year) && $year !== 'any') {
                        $conditions[] = "mcl.year = '" . $year . "'";
                    }
                    if (!empty($month) && $month !== 'any') {
                        $conditions[] = "mcl.month = '" . $month . "'";
                    }

                    if (!empty($conditions)) {

                        $query .= ' WHERE ' . implode(' AND ', $conditions);
                    }


                    $result = DB::select($query);
                    return response()->json(['data' => $result,]);
                }
            } else {
                if ($year == "any" && $month == "any") {

                    $query = "SELECT mcl.member_contribution_ledger_id,mcl.member_id,C.contribution_id,C.contribution_code,C.contribution_title,C.amount
                    FROM member_contribution_ledgers mcl
                    LEFT JOIN members M ON mcl.member_id=M.id
                    LEFT JOIN contributions C ON C.contribution_id=mcl.contribution_id
                    WHERE mcl.member_id= $id";
                    $members = DB::select($query);
                    return response()->json(['data' => $members,]);
                } else {

                    $query = "SELECT mcl.member_contribution_ledger_id,mcl.member_id,C.contribution_id,C.contribution_code,C.contribution_title,C.amount
                    FROM member_contribution_ledgers mcl
                    LEFT JOIN members M ON mcl.member_id=M.id
                    LEFT JOIN contributions C ON C.contribution_id=mcl.contribution_id";
                    $conditions = array();

                    if (!empty($year) && $year !== 'any') {
                        $conditions[] = "mcl.year = '" . $year . "'";
                    }
                    if (!empty($month) && $month !== 'any') {
                        $conditions[] = "mcl.month = '" . $month . "'";
                    }

                    if (!empty($conditions)) {
                        $query .= " WHERE mcl.member_id = $id AND " . implode(' AND ', $conditions);
                    }

                    $result = DB::select($query);
                    return response()->json(['data' => $result,]);
                }
                /* $query = "SELECT mcl.member_contribution_ledger_id,mcl.member_id,C.contribution_id,C.contribution_code,C.contribution_title,C.amount
                    FROM member_contribution_ledgers mcl
                    LEFT JOIN members M ON mcl.member_id=M.id
                    LEFT JOIN contributions C ON C.contribution_id=mcl.contribution_id
                    WHERE mcl.member_id= $id";

                $contribution = DB::select($query);
                //dd($contribution);

                return response()->json((['success' => 'Data loaded', 'data' => $contribution]));*/
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getLoan()
    {

        try {
            $loan = loan::all();
            return response()->json($loan);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getmemberloandata(Request $request, $id)
    {
        try {

            $year = $request->input('cmb_year');
            $month = $request->input('cmb_month');
            if ($id == 0) {
                if ($year == "any" && $month == "any") {

                    $query = "SELECT ml.member_loan_ledger_id,ml.loan_term_id,l.loan_name,l.loan_code,l.amount
                    FROM member_loan_ledgers ml
                    LEFT JOIN loans l ON l.loan_id = ml.loan_id";
                    $members = DB::select($query);
                    return response()->json(['data' => $members,]);
                } else {

                    $query = "SELECT ml.member_loan_ledger_id,ml.loan_term_id,l.loan_name,l.loan_code,l.amount
                    FROM member_loan_ledgers ml
                    LEFT JOIN loans l ON l.loan_id = ml.loan_id";
                    $conditions = array();

                    if (!empty($year) && $year !== 'any') {
                        $conditions[] = "ml.year = '" . $year . "'";
                    }
                    if (!empty($month) && $month !== 'any') {
                        $conditions[] = "ml.month = '" . $month . "'";
                    }

                    if (!empty($conditions)) {

                        $query .= ' WHERE ' . implode(' AND ', $conditions);
                    }


                    $result = DB::select($query);
                    return response()->json(['data' => $result,]);
                }
            } else {
             
                if ($year == "any" && $month == "any") {

                    $query = "SELECT ml.member_loan_ledger_id,ml.loan_term_id,l.loan_name,l.loan_code,l.amount
                    FROM member_loan_ledgers ml
                    LEFT JOIN loans l ON l.loan_id = ml.loan_id
                    WHERE ml.member_id= $id ";

                    $members = DB::select($query);
                    return response()->json(['data' => $members,]);
                } else {

                    $query = "SELECT ml.member_loan_ledger_id,ml.loan_term_id,l.loan_name,l.loan_code,l.amount
                    FROM member_loan_ledgers ml
                    LEFT JOIN loans l ON l.loan_id = ml.loan_id";
                    $conditions = array();

                    if (!empty($year) && $year !== 'any') {
                        $conditions[] = "ml.year = '" . $year . "'";
                    }
                    if (!empty($month) && $month !== 'any') {
                        $conditions[] = "ml.month = '" . $month . "'";
                    }

                    if (!empty($conditions)) {
                        $query .= " WHERE ml.member_id = $id AND " . implode(' AND ', $conditions);
                    }
                  // dd($query);
                    $result = DB::select($query);
                    return response()->json(['data' => $result,]);
                }
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function subserveDepartmentmember($id)
    {
        try {
            $query = "SELECT M.id FROM master_sub_departments MSD
            LEFT JOIN members M ON M.serving_sub_department_id = MSD.id
            WHERE MSD.id = $id";
            $subid = DB::select($query);
            return response()->json($subid);
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
