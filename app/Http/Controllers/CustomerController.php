<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    //
    public function saveCustomer(Request $request)
    {


        try {
            $request->validate([
                'customer_id' => 'required',
                'customer_name' => 'required',
                'credit_limit' => 'required|numeric',
                'customer_address' => 'required',
            ]);


            $customer = new Customer();
            $customer->customer_id = $request->get('customer_id');
            $customer->customer_name = $request->get('customer_name');
            $customer->credit_limit = $request->get('credit_limit');
            $customer->customer_address = $request->get('customer_address');

            if ($customer->save()) {
                return response()->json(["status" => true]);
            }
            return response()->json(["status" => false]);
        } catch (Exception $ex) {

            if ($ex instanceof ValidationException) {
                return response()->json(["ValidationException" => ["id" => collect($ex->errors())->keys()[0], "message" => $ex->errors()[collect($ex->errors())->keys()[0]]]]);
            }
        }
    }
}
