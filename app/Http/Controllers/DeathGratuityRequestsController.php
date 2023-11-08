<?php

namespace App\Http\Controllers;

use App\Models\death_gratuity_requests;
use App\Models\death_gratuity_requests_attachment;
use App\Models\MasterDesignation;
use App\Models\MasterSubDepartment;
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
        } catch (Exception $ex) {
            return $ex;
        }
    }
    public function getdepartmentsection()
    {
        $member = MasterSubDepartment::all();
        if ($member) {
            return response()->json((['success' => 'Data loaded', 'data' => $member, 'not filter']));
        } else {
            return response()->json((['error' => 'Data is not loaded']));
        }
    }


    public function getPosition()
    {

        $member = MasterDesignation::all();
        if ($member) {
            return response()->json((['success' => 'Data loaded', 'data' => $member, 'not filter']));
        } else {
            return response()->json((['error' => 'Data is not loaded']));
        }
    }

    public function saveDeathgratuityrequests(Request $request)
    {

        try {

            $saveDeathgratuity = new death_gratuity_requests();
            $saveDeathgratuity->member_id = $request->get('txtmembershipno');
            $saveDeathgratuity->designation_id  = $request->get('txtPosition');
            $saveDeathgratuity->full_name_of_the_deceased_person  = $request->get('txtfullnameofthedeceasedperson');

            $saveDeathgratuity->serving_sub_department_id  = $request->get('txtdepartmentsection');
            $saveDeathgratuity->date_and_place_of_death = $request->get('txtdateandplaseofdeath');
            $saveDeathgratuity->relationship_to_the_deceased_person  = $request->get('txtrelationshiptothedeceased');

            $saveDeathgratuity->age_of_deceased  = $request->get('txtageifthedeceasedchildmember');
            $saveDeathgratuity->gender_of_deceased_person  = $request->get('txtGenderdeceasedperson');
            $saveDeathgratuity->death_certificate_No  = $request->get('txtDeathcertificateNo');

            $saveDeathgratuity->issued_date  = $request->get('txtIssueddate');
            $saveDeathgratuity->issued_place  = $request->get('txtissuedplace');

            $saveDeathgratuity->birth_certificate_no  = $request->get('txtbirthcertificateno');
            $saveDeathgratuity->marriage_certificate_no  = $request->get('txtmarriagecertificateeno');
            $saveDeathgratuity->date_of_oic  = $request->get('txtreceiptofofficechargecertificate');
            $saveDeathgratuity->note  = $request->get('txtoutherdetails');
            $saveDeathgratuity->gs_date = $request->get('txtgsdate');

            if ($saveDeathgratuity->save()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function alldeathgratuity()
    {
        try {
            $deathgratuity = 'SELECT * FROM death_gratuity_requests ORDER BY approval_status ASC';


            $result = DB::select($deathgratuity);
            if ($result) {
                return response()->json((['success' => 'Data loaded', 'data' => $result]));
            } else {
                return response()->json((['error' => 'Data is not loaded', 'data' => []]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function update_deathgratuity(Request $request, $id)
    {
        try {


            $saveDeathgratuity = death_gratuity_requests::find($id);
            $saveDeathgratuity->member_id = $request->get('txtmembershipno');
            $saveDeathgratuity->designation_id  = $request->get('txtPosition');
            $saveDeathgratuity->full_name_of_the_deceased_person  = $request->get('txtfullnameofthedeceasedperson');

            $saveDeathgratuity->serving_sub_department_id  = $request->get('txtdepartmentsection');
            $saveDeathgratuity->date_and_place_of_death = $request->get('txtdateandplaseofdeath');
            $saveDeathgratuity->relationship_to_the_deceased_person  = $request->get('txtrelationshiptothedeceased');

            $saveDeathgratuity->age_of_deceased  = $request->get('txtageifthedeceasedchildmember');
            $saveDeathgratuity->gender_of_deceased_person  = $request->get('txtGenderdeceasedperson');
            $saveDeathgratuity->death_certificate_No  = $request->get('txtDeathcertificateNo');

            $saveDeathgratuity->issued_date  = $request->get('txtIssueddate');
            $saveDeathgratuity->issued_place  = $request->get('txtissuedplace');

            $saveDeathgratuity->birth_certificate_no  = $request->get('txtbirthcertificateno');
            $saveDeathgratuity->marriage_certificate_no  = $request->get('txtmarriagecertificateeno');
            $saveDeathgratuity->date_of_oic  = $request->get('txtreceiptofofficechargecertificate');
            $saveDeathgratuity->note  = $request->get('txtoutherdetails');
            $saveDeathgratuity->gs_date = $request->get('txtgsdate');


            if ($saveDeathgratuity->update()) {

                return response()->json(['status' => true]);
            } else {

                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }










    public function getdeathgratuityrequest($id)
    {
        try {
            $deathgratuity = death_gratuity_requests::find($id);
            return response()->json($deathgratuity);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // file attachment
    public function deathgratuitysaveattachment(Request $request, $id)
    {

        try {

            $file = $request->file('file');

            $attachment = new death_gratuity_requests_attachment();
            $attachment->description = $request->get('txtDescription');
            $attachment->death_gratuity_requestss_id = $id;
            if ($attachment->save()) {
                if ($file) {

                    $this->uploadAttachment($file, $attachment->death_gratuity_requests_attachments_id);
                }
            }
        } catch (Exception $ex) {
            return  $ex;
        }
    }

    public function uploadAttachment($file, $id)
    {



        try {
            $exAttachment = death_gratuity_requests_attachment::where('death_gratuity_requests_attachments_id', $id)->first();

            if ($exAttachment) {

                $ex_filepath = $exAttachment->attachment;

                if ($ex_filepath) {
                    $baseUrl = url('/') . "/attachments/death_gratuity_requests_file/";
                    $file_data =  str_replace($baseUrl, '', $ex_filepath);
                    $file_data = public_path('attachments/death_gratuity_requests_file') . '/' . $file_data;

                    if (file_exists($file_data)) {
                        unlink($file_data);
                    }
                }

                $file_name = $file->getClientOriginalName();
                $filename = url('/') . '/attachments/death_gratuity_requests_file/' . uniqid() . '_' . time() . '.' . str_replace(' ', '_', $file_name);
                $filename = str_replace(' ', '', str_replace('\'', '', $filename));
                $file->move(public_path('attachments/death_gratuity_requests_file'), $filename);

                $data = DB::table('death_gratuity_requests_attachments')
                    ->where('death_gratuity_requests_attachments_id', $id)
                    ->update(['attachment' => $filename]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getdeathgratuityAttachment($id)
    {

        try {

            $query = 'SELECT * FROM death_gratuity_requests_attachments DGRS WHERE DGRS.death_gratuity_requestss_id="' . $id . '"';
            $attachment = DB::select($query);

            return response()->json($attachment);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function viewdeathgratuityAttachment($id)
    {
        try {
            $request = death_gratuity_requests_attachment::find($id);
            return response()->json($request);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function deletadeathgratuityttachment($id)
    {
        try {

            $request = death_gratuity_requests_attachment::find($id);
            $filePath = $request->attachment;

            if ($filePath) {
                $baseUrl = url('/') . "/attachments/death_gratuity_requests_file/";

                $file =  str_replace($baseUrl, '', $filePath);
                $file = public_path('attachments/death_gratuity_requests_file') . '/' . $file;

                if (file_exists($file)) {
                    unlink($file);
                }

                if ($request) {

                    $request->delete();

                    return "deleted";
                } else {
                    return "failed";
                }
            }
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    public function deletedeathgratuity($id)
    {
        try {
            $death_gratuity = death_gratuity_requests::find($id);

            $delet = $death_gratuity->delete();
            if ($delet) {
                $deletattachment =  $death_gratuity->death_gratuity_requestss_id;

                //$death_gratuityAttachment = death_gratuity_requests_attachment::find($deletattachment);
                $death_gratuityAttachments = death_gratuity_requests_attachment::where('death_gratuity_requestss_id', $deletattachment)->get();

                if ($death_gratuityAttachments->isEmpty()) {
                    return response()->json(['success' => 'Record has been Delete']);
                } else {
                    // dd( $death_gratuityAttachments);
                    foreach ($death_gratuityAttachments as $attachment) {
                        $filePath = $attachment->attachment;

                        if ($filePath) {
                            $baseUrl = url('/') . "/attachments/death_gratuity_requests_file/";

                            $file =  str_replace($baseUrl, '', $filePath);
                            $file = public_path('attachments/death_gratuity_requests_file') . '/' . $file;

                            if (file_exists($file)) {
                                unlink($file);
                            }

                            if ($death_gratuityAttachments->isNotEmpty()) {
                                foreach ($death_gratuityAttachments as $attachment) {
                                    $filePath = $attachment->attachment;
                                    $attachment->delete();
                                }
                            }
                            return response()->json(['success' => 'Record has been Delete']);
                        } else {
                            return "failed";
                        }
                    }
                }
            }else {
                return "failed";
            }
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    // Approvel
    public function alldeathgratuityapprovelapprovel()
    {
        try {
            $query = 'SELECT * FROM death_gratuity_requests DGR  WHERE DGR.approval_status="0"';

            $pendingApprovals = DB::select($query);
            if ($pendingApprovals) {
                return response()->json((['success' => 'Data loaded', 'data' => $pendingApprovals]));
            } else {
                return response()->json((['error' => 'Data not loaded', 'data' => []]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function approvedeathgratuityRequest($id)
    {
        try {
            $request = death_gratuity_requests::find($id);
            $request->approval_status = 1;

            if ($request->update()) {
                return response()->json((['status' => true]));
            } else {
                return response()->json((['status' => false]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function rejectdeathgratuityRequest($id)
    {
        try {
            $request = death_gratuity_requests::find($id);
            $request->approval_status = 2;

            if ($request->update()) {
                return response()->json((['status' => true]));
            } else {
                return response()->json((['status' => false]));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
