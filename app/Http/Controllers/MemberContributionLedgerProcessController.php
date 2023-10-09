<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use App\Models\Member;
use App\Models\member_contribution;
use App\Models\MemberContributionLedger;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class MemberContributionLedgerProcessController extends Controller
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

    public function member_contribution_ledger_process(Request $request)
    {
        try {
            $members = Member::all();
            foreach ($members as $member) {
                $member_contributions  = member_contribution::where('member_id', '=', $member->id)->first();
                if ($member_contributions) {
                    $memberContributionLedger = new MemberContributionLedger();
                    $memberContributionLedger->contribution_id = $member_contributions->contributions_id;
                    $memberContributionLedger->member_id = $member->id;
                    $memberContributionLedger->year = $request->get('current_year');
                    $memberContributionLedger->month = $request->get('current_month');
                    $memberContributionLedger->amount = $member_contributions->amount;
                    $memberContributionLedger->processed_date = Carbon::now()->format('Y-m-d');
                    $memberContributionLedger->status = 1;
                    $status = $memberContributionLedger->save();
                }
            }
            $globalSetting = GlobalSetting::find(1);
            if ($globalSetting) {
                $year = $globalSetting->current_year;
                $month = ($globalSetting->current_month + 1);
                if ($month > 12) {
                    $month = 1;
                    $year = ($year + 1);
                }
                $globalSetting->current_year = $year;
                $globalSetting->current_month = $month;
                $globalSetting->update();
            }
            return response()->json(["status" => true, "data" => null]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }
}
