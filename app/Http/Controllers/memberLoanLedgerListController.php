<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class memberLoanLedgerListController extends Controller
{
   
    // member load
    public function getMemberloan()
    {
        try {
            $members = Member::all();
            return response()->json(['data' => $members,]);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function allmemberloanledgerdata(Request $request)
    {

        try {

            $number = $request->input('cmb_number');
            $name = $request->input('cmb_name');
            $year = $request->input('cmb_year');
            $month = $request->input('cmb_month');

            if ($number == "any" && $name == "any" && $year == "any" && $month == "any") {

                $query = "SELECT *,members.member_number,members.full_name FROM member_loan_ledgers mll
                INNER JOIN members ON members.id = mll.member_id";
                $members = DB::select($query);
                return response()->json(['data' => $members,]);
            } else {
                $conditions = array();

                $query = "SELECT *,members.member_number,members.full_name FROM member_loan_ledgers mll
                INNER JOIN members ON members.id = mll.member_id";
                if (!empty($number) && $number !== 'any') {
                    $conditions[] = "members.member_number = '" . $number . "'";
                }
                if (!empty($name) && $name !== 'any') {
                    $conditions[] = "members.full_name = '" . $name . "'";
                }
                if (!empty($year) && $year !== 'any') {
                    $conditions[] = "mll.year = '" . $year . "'";
                }
                if (!empty($month) && $month !== 'any') {
                    $conditions[] = "mll.month = '" . $month . "'";
                }

                if (!empty($conditions)) {

                    $query .= ' WHERE ' . implode(' AND ', $conditions);
                }
               // dd($query);
                $result = DB::select($query);
                return response()->json(['data' => $result,]);

            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
