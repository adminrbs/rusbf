<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\member_contribution;
use App\Models\MemberAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\contribution;

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


    public function memberNumber($id)
    {
        try {
            if ($id == 0) {
                $member = Member::all();
                if ($member) {
                    return response()->json((['success' => 'Data loaded', 'data' => $member, 'not filter']));
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
          /*  if ($id == 0) {
                $query = "
                (SELECT id, member_number, full_name FROM members)
                UNION ALL
                (SELECT 0 AS id, 'Select Member Number' AS member_number, NULL AS full_name)
                ORDER BY member_number DESC";

                $Member = DB::select($query);
                return response()->json($Member);
            } else {
                $query = 'SELECT id, member_number, full_name
                FROM members
                WHERE id= ' . $id . '';

                $Member = DB::select($query);
                if ($Member) {

                    return response()->json($Member);
                } else {
                    return response()->json(['status' => false]);
                }
            }*/
        } catch (Exception $ex) {
            return $ex;
        }
    }




    public function computerNumber($id)
    {
        try {
            if ($id == 0) {
                $query = "
                (SELECT id, computer_number, full_name FROM members)
                UNION ALL
                (SELECT 0 AS id, 'Select Computer Number' AS computer_number, NULL AS full_name)
                ORDER BY computer_number DESC";

                $Member = DB::select($query);
                return response()->json($Member);
            } else {
                $query = 'SELECT id, computer_number, full_name
                FROM members
                WHERE id= ' . $id . '';

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
                $query = " (SELECT id, member_number,full_name FROM members)
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

    public function imageloard($id)
    {
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
}
