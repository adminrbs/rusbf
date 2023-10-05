<?php


namespace App\Http\Controllers;

use App\Models\loan;
use App\Models\loan_term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loneManagementController extends Controller
{
    public function loansave(Request $request)
    {
        try {

            $loan = new loan();

            $loan->loan_code = $request->get('txtloneCode');
            $loan->loan_name = $request->get('txtname');
            $loan->description = $request->get('txtdescription');
            $loan->amount = $request->get('txtamount');
            $loan->duration_of_membership = $request->get('txtdurationofmember');
            $loan->remarks = $request->get('txtremarks');
            $loan->gl_account_no = $request->get('txtAccount');

            if ($loan->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex]);
        }
    }

    public function loanallData()
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

    public function getloan($id)
    {
        try {
            $loan = loan::find($id);
            return response()->json($loan);
        } catch (Exception $ex) {
            return $ex;
        }
    }
    public function getloneupdate(Request $request, $id)
    {

        try {

            $loan = loan::find($id);
            $loan->loan_code = $request->get('txtloneCode');
            $loan->loan_name = $request->get('txtname');
            $loan->description = $request->get('txtdescription');
            $loan->amount = $request->get('txtamount');
            $loan->duration_of_membership = $request->get('txtdurationofmember');
            $loan->remarks = $request->get('txtremarks');
            $loan->gl_account_no = $request->get('txtAccount');
            $loan->update();
            return response()->json($loan);
        } catch (Exception $ex) {
            return $ex;
        }
    }
    public function deletelone($id)
    {

        try {
            $loan = loan::find($id);

            $loan->delete();
            return response()->json(['success' => 'Record has been Delete']);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    // lone term management

    public function lonetermsave(Request $request, $id)
    {
        try {

            $loan_term = new loan_term();
            $loan_term->loan_id = $id;
            $loan_term->no_of_terms = $request->get('txtloneterm');
            $loan_term->term_amount = $request->get('txttermAmount');
            $loan_term->term_interest_amount = $request->get('txtinteresttermAmount');
            $loan_term->term_interest_precentage = $request->get('txtrempresenttage');
            $loan_term->remarks = $request->get('txttermremaks');


            if ($loan_term->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex]);
        }
    }

    public function lonetermAllData($id)
    {

        try {
            $qury = "SELECT loan_terms.*, loans.loan_code, loans.loan_name 
            FROM loan_terms
            INNER JOIN loans ON loan_terms.loan_id = loans.loan_id
            WHERE loan_terms.loan_id =$id";

            $loan_term = DB::select($qury);

            return response()->json((['success' => 'Data loaded', 'data' => $loan_term]));
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getloneterm($id)
    {

        try {
            $loan_term = loan_term::find($id);
            return response()->json($loan_term);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function updateloneterm(Request $request, $id)
    {
        try {

            $loan_term = loan_term::find($id);
            $loan_term->no_of_terms = $request->get('txtloneterm');
            $loan_term->term_amount = $request->get('txttermAmount');
            $loan_term->term_interest_amount = $request->get('txtinteresttermAmount');
            $loan_term->term_interest_precentage = $request->get('txtrempresenttage');
            $loan_term->remarks = $request->get('txttermremaks');
            $loan_term->update();
            return response()->json($loan_term);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function deleteloneterm($id)
    {
        try {
            $loan_term = loan_term::find($id);

            $loan_term->delete();
            return response()->json(['success' => 'Record has been Delete']);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

public function cbxlonee(Request $request,$id){
    try {

        $supplygroup = loan::findOrFail($id);
        $supplygroup->status = $request->status;
        $supplygroup->save();

        return response()->json(' status updated successfully');
    } catch (Exception $ex) {
        return response()->json($ex);
    }

}
}
