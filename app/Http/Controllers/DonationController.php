<?php

namespace App\Http\Controllers;

use App\Models\donation;
use Exception;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function save_donetion(Request $request)
    {
        try {
            $donetion = new donation();
            $donetion->donation  = $request->get('txtdonation');
            if ($donetion->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function get_donetion()
    {
        try {
            $donations = Donation::orderBy('created_at', 'desc')->get();
            if ($donations) {
                return response()->json((['success' => 'Data loaded', 'data' => $donations]));
            } else {
                return response()->json((['error' => 'Data is not loaded']));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function get_donetion_data($id)
    {
        try {
            $donetion = donation::find($id);
            return response()->json($donetion);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update_donetion(Request $request)
    {
        try {

            $id = $request->get('id');

            $donetion = donation::find($id);
            $donetion->donation  = $request->get('txtdonation');


            if ($donetion->update()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }


public function delete_donetion($id){
    try {
        $donation = donation::find($id);

        $donation->delete();
        return response()->json(['success' => 'Record has been Delete']);
    } catch (Exception $ex) {
        return response()->json($ex);
    }

}

public function cbxdonation(Request $request ,$id){

    try {

        $donation = donation::findOrFail($id);
        $donation->is_active = $request->status;
        $donation->save();

        return response()->json(' status updated successfully');
    } catch (Exception $ex) {
        return response()->json($ex);
    }
}
}
