<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustommerAttachment;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;

class FormController extends Controller
{
    //
    public function saveCustomer(Request $request)
    {


        try {


            $file =  $request->file('file');
            $customer = new Customer();
            $customer->customer_id = $request->get('customer_id');
            $customer->customer_name = $request->get('customer_name');
            $customer->credit_limit = $request->get('credit_limit');
            $customer->customer_address = $request->get('customer_address');

            if ($customer->save()) {
                $this->uploadAttachment($file, $customer->id);
                return response()->json(["status" => true, "file" => $file]);
            }
            return response()->json(["status" => false]);
        } catch (Exception $ex) {
        }
    }


    public function uploadAttachment($file, $id)
    {

        if ($file) {
            $file_name = $file->getClientOriginalName();
            $filename = url('/') . '/attachment/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
            $filename = str_replace(' ', '', str_replace('\'', '', $filename));
            $file->move(public_path('attachment'), $filename);

            $attachment = new CustommerAttachment();
            $attachment->customer_id = $id;
            $attachment->path = $filename;
            $attachment->save();
        }
    }
}
