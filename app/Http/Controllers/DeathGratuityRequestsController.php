<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeathGratuityRequestsController extends Controller
{
    public function alldatamemberShip($id)
    {
        try {

            if ($id == 0) {
                $member = Member::all();
                if ($member) {
                    return response()->json((['success' => 'Data loaded', 'data' => $member,'not filter']));
                } else {
                    return response()->json((['error' => 'Data is not loaded']));
                }
            } else {
                $quary = " SELECT M.*
                FROM members M
                ORDER BY (M.id = $id) DESC";

                $member = DB::select($quary);
                if ($member) {
                    return response()->json((['success' => 'Data loaded', 'data' => $member]));
                } else {
                    return response()->json((['error' => 'Data is not loaded']));
                }
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
