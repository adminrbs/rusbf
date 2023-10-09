<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\contribution;
use Illuminate\Support\Facades\DB;

class contributnController extends Controller
{
    public function save_contribution(Request $request)
    {


        $validatedData = $request->validate([
            'txtNamecontribution' => 'required',
            'txtContribute' => 'required',
        ]);

        try {

            $contribution = new contribution();
            $contribution->contribution_code  = $request->get('code');
            $contribution->contribution_title = $request->get('txtNamecontribution');
            $contribution->description = $request->get('txtDescription');
            $contribution->contribute_on_every = $request->get('txtContribute');
            $contribution->gl_account_no = $request->get('txtglaccount');


            if ($contribution->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function allcontributedata()
    {
        try {
            $query = "SELECT *, l.amount FROM contributions
            INNER JOIN loans l ON contributions.gl_account_no=l.gl_account_no";
$contribution =DB::select($query);
            if ($contribution) {
                return response()->json((['success' => 'Data loaded', 'data' => $contribution]));
            } else {
                return response()->json((['error' => 'Data is not loaded']));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
    public function getcontribute($id)
    {
        try {
            $contribution = contribution::find($id);

            //dd($supplygroup);
            return response()->json($contribution);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update_contribution(Request $request, $id)
    {
        $validatedData = $request->validate([
            'txtNamecontribution' => 'required',
            'txtContribute' => 'required',
        ]);

        try {

            $contribution = contribution::find($id);
            $contribution->contribution_code  = $request->get('code');
            $contribution->contribution_title = $request->get('txtNamecontribution');
            $contribution->description = $request->get('txtDescription');
            $contribution->contribute_on_every = $request->get('txtContribute');
            $contribution->gl_account_no = $request->get('txtglaccount');


            if ($contribution->update()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function deletecontribute($id)
    {


        try {
            $level3 = contribution::find($id);

            $level3->delete();
            return response()->json(['success' => 'Record has been Delete']);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    public function cbxcontribute(Request $request ,$id)
    {
        try {

            $supplygroup = contribution::findOrFail($id);
            $supplygroup->status = $request->status;
            $supplygroup->save();
    
            return response()->json(' status updated successfully');
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }
}
