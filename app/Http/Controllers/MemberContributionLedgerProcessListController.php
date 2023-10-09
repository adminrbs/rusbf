<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberContributionLedgerProcessListController extends Controller
{
    //
    public function getMemberContributions($filters)
    {
        try {

            $filters =  json_decode($filters);
            $query = "SELECT members.member_number,
            members.full_name,
            member_contribution_ledgers.`year`,
            MONTHNAME(STR_TO_DATE(member_contribution_ledgers.`month`, '%m')) AS month,
            FORMAT(member_contribution_ledgers.amount, 2) AS amount
            FROM member_contribution_ledgers
            INNER JOIN members ON member_contribution_ledgers.member_id = members.id WHERE ";

            if ($filters->member_id != "any") {
                $query .= "members.id = '" . $filters->member_id  . "' AND ";
            }
            if ($filters->year != "any") {
                $query .= "member_contribution_ledgers.year = '" . $filters->year . "' AND ";
            }
            if ($filters->month != "any") {
                $query .= "member_contribution_ledgers.month = '" . $filters->month . "' AND";
            }
            $query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);
            return response()->json(["status" => true, "data" => DB::select($query)]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }

    public function getMembers()
    {
        try {
            return response()->json(["status" => true, "data" => ["members" => Member::all(), "date" => $this->getCurrentYearMonth()]]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }


    public function getCurrentYearMonth()
    {
        $globalSettings = GlobalSetting::find(1);
        if ($globalSettings) {
            return $globalSettings->current_year;
        }
        return 0;
    }
}
