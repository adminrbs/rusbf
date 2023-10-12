<?php

namespace App\Http\Controllers;

use App\Models\member_loan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberLoanController extends Controller
{
    
    public function memberloandata($id)
    {
        try {

            if ($id == 0) {


                $query = "SELECT ml.member_loan_id,ml.member_id, ml.no_of_terms,ml.term_amount,ml.status,ml.term_interest_precentage,l.loan_name,l.loan_code,l.amount
                FROM member_loans ml
                LEFT JOIN loans l ON l.loan_id = ml.loan_id";

                $contribution = DB::select($query);
                if ($contribution) {
                    return response()->json((['success' => 'Data loaded', 'data' => $contribution]));
                } else {
                    return response()->json((['error' => 'Data is not loaded']));
                }
            } else {
                $query = "SELECT ml.member_loan_id,ml.member_id, ml.no_of_terms,ml.term_amount,ml.status,ml.term_interest_precentage,l.loan_name,l.loan_code,l.amount
                FROM member_loans ml
                LEFT JOIN loans l ON l.loan_id = ml.loan_id
                WHERE ml.member_id= $id";

                $contribution = DB::select($query);
                //dd($contribution);

                return response()->json((['success' => 'Data loaded', 'data' => $contribution]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function memberlonestatus(Request $request ,$id)
    {
        try {

            $member_loan = member_loan::findOrFail($id);
            $member_loan->status = $request->status;
            $member_loan->save();
    
            return response()->json(' status updated successfully');
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }
}
