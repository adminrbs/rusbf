<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentVoucerController extends Controller
{
    //
    public function save(Request $request)
    {

        try {
            $voucher_number = $request->get('voucher_number');
            $voucher_date = $request->get('voucher_date');
            $ledger_number = $request->get('ledger_number');
            $member_number = $request->get('member_number');
            $cheque_number = $request->get('cheque_number');
            $data = json_decode($request->get('data'));


            $paymentVoucher = new PaymentVoucher();
            $paymentVoucher->voucher_number = $voucher_number;
            $paymentVoucher->voucher_date = $voucher_date;
            $paymentVoucher->ledger_number = $ledger_number;
            $paymentVoucher->member_number = $member_number;
            $paymentVoucher->cheque_number = $cheque_number;
            $paymentVoucher->prepared_by = Auth::user()->id;
            if ($paymentVoucher->save()) {
                for ($i = 0; $i < count($data); $i++) {
                    $discription =  $data[$i][0];
                    $amount =  $data[$i][1];

                    $paymentVoucherItem = new PaymentVoucherItem();
                    $paymentVoucherItem->payment_voucher_id = $paymentVoucher->payment_voucher_id;
                    $paymentVoucherItem->discription = $discription;
                    $paymentVoucherItem->amount = $amount;
                    $paymentVoucherItem->save();
                }
            }

            return response()->json(["status" => true, "data" => null]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }


    public function getMembers()
    {

        try {
            $members = Member::all();

            return response()->json(["status" => true, "data" => $members]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }


    public function getMemberName($id)
    {

        try {
            $member = Member::find($id);

            return response()->json(["status" => true, "data" => $member]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }
}
