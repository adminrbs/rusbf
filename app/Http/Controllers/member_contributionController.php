<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class member_contributionController extends Controller
{
    public function memberNumber($id)
    {
        try {
            if ($id == 0) {
                $query ="
                (SELECT id, member_number, full_name FROM members)
                UNION ALL
                (SELECT NULL AS id, 'Select Member Number' AS member_number, NULL AS full_name)
                ORDER BY member_number DESC";

                $Member = DB::select($query);
                return response()->json($Member);
            } else {
                $query ='SELECT id, member_number, full_name
                FROM members
                WHERE id= ' .$id.'';

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

    public function fullName($id)
    {
        try {
            if ($id == 0) {
                $query =" (SELECT id, member_number,full_name FROM members)
                UNION ALL
                (SELECT 0 AS id,NULL AS member_number,'Select Full Name' AS full_name)
                ORDER BY id ASC";

                $Member = DB::select($query);

                return response()->json($Member);
            } else {
                $Member = Member::where('id', '=', $id)->get();
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

public function imageloard($id){
    try {
        if ($id == 0) {
            $Member = MemberAttachment::all();

            return response()->json($Member);
        } else {
            $Member = MemberAttachment::where('member_id', '=', $id)->get();

            return response()->json($Member);
        }
    } catch (Exception $ex) {
        return $ex;
    }
}
}
 /* try {
            if ($id == 0) {
                $Member = Member::all();

                return response()->json($Member);
            } else {
                $Member = Member::find($id);

                return response()->json($Member);
            }
        } catch (Exception $ex) {
            return $ex;
        }*/



/*
SELECT member_data
FROM (

    SELECT 'select member' AS member_data, 1 AS sort_order

 
    UNION ALL

  
    SELECT CONCAT(id, member_number) AS member_data, 2 AS sort_order
    FROM members
) combined_data
ORDER BY sort_order;
*/ 