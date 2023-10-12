<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use App\Models\Member;
use App\Models\member_contribution;
use App\Models\member_loan;
use App\Models\MemberContributionLedger;
use App\Models\MemberLoanLedger;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberLoanLedgerController extends Controller
{
    //
    public function getCurrentYearMonth()
    {
        try {
            return response()->json(["status" => true, "data" => GlobalSetting::find(1)]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }

    public function member_loan_ledger_process(Request $request)
    {
        try {
            $members = Member::all();
            foreach ($members as $member) {
                $member_loan  = member_loan::where('member_id', '=', $member->id)->first();
                if ($member_loan) {
                    if ($member_loan->no_of_terms > $member_loan->current_term) {
                        $interest_amount = 0;
                        if ($member_loan->term_interest_amount) {
                            $interest_amount = $member_loan->term_interest_amount;
                        } else {
                            $interest_amount = ($member_loan->term_amount / 100) * $member_loan->term_interest_precentage;
                        }
                        $memberLoanLedger = new MemberLoanLedger();
                        $memberLoanLedger->member_loan_id = $member_loan->member_loan_id;
                        $memberLoanLedger->member_id = $member->id;
                        $memberLoanLedger->loan_id =  $member_loan->loan_id;
                        $memberLoanLedger->loan_term_id =  $member_loan->loan_term_id;
                        $memberLoanLedger->term =  $member_loan->no_of_terms;
                        $memberLoanLedger->amount =  $member_loan->term_amount;
                        $memberLoanLedger->interest_amount =  $interest_amount;
                        $memberLoanLedger->paid_amount =  0;
                        $memberLoanLedger->paid_interest =  0;
                        $memberLoanLedger->year = $request->get('current_year');
                        $memberLoanLedger->month = $request->get('current_month');
                        $memberLoanLedger->processed_date = Carbon::now()->format('Y-m-d');
                        $memberLoanLedger->user_id = Auth::user()->id;
                        $memberLoanLedger->status = 1;
                        $status = $memberLoanLedger->save();
                        if ($status) {
                            $member_loan->current_term += 1;
                            $member_loan->update();
                        }
                    }
                }
            }
            return response()->json(["status" => true, "data" => null]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }
}
