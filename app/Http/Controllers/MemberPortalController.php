<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\memberPortal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberPortalController extends Controller
{

    public function getallmembers($id)
    {
        try {

            if ($id == 0) {

                $data = DB::select("SELECT  M.id,M.full_name
                 FROM members M
                 LEFT JOIN member_portals MP ON M.id = MP.member_id
                 WHERE M.id != MP.member_id OR MP.member_id IS NULL;");
                return response()->json($data);
            } else {

                $data = Member::all();
                return response()->json($data);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function savemembwrPortal(Request $request)
    {

        try {


            $existingMember = memberPortal::where('user_name', $request->get('txtusername'))->first();
            $Memberid = memberPortal::where('member_id', $request->get('cmbmemberprtal'))->first();
            // if ($Memberid !== null) {
            //     return response()->json(["message" => "create_member"]);
            // } else {
            if ($existingMember !== null) {

                return response()->json(["message" => "create_user"]);
            } else {

                $memberPortal = new memberPortal();
                $memberPortal->member_id = $request->get('cmbmemberprtal');
                $memberPortal->user_name = $request->get('txtusername');
                $memberPortal->password = Hash::make($request->input('txtPassword'));


                if ($memberPortal->save()) {

                    return response()->json(['message' => true]);
                } else {

                    return response()->json(['message' => false]);
                }
            }
            //}
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function memberportalAllData()
    {
        try {
            $data = memberPortal::all();
            return response()->json($data);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function get_memberportel_data($id)
    {
        try {
            $data = memberPortal::find($id);
            return response()->json($data);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update_embwrPortal(Request $request, $id)
    {
        try {


            $memberPortal = memberPortal::findOrFail($id);
            $memberPortal->member_id = $request->get('cmbmemberprtal');
            $memberPortal->user_name = $request->get('txtusername');
            $memberPortal->password = Hash::make($request->input('txtPassword'));

            if ($memberPortal->update()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function deletememberpotal($id)
    {
        $memberportal = memberPortal::find($id);
        $memberportal->delete();
        return response()->json(['success' => 'Record has been Delete']);
    }


public function cbxmemberportelStatus(Request $request ,$id)
{
try{

    $memberportal = memberPortal::findOrFail($id);
    $memberportal->status = $request->status;
    $memberportal->save();

    return response()->json(' status updated successfully');

} catch (Exception $ex) {
    return $ex;
}

}
}
