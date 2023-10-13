<?php

namespace App\Http\Controllers;

use App\Models\MasterDesignation;
use App\Models\MasterPlaceWork;
use App\Models\MasterSubDepartment;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class memberreportController extends Controller
{
    public function getmembersreport()
    {
        try {
            /*$quary ="SELECT m.computer_number msd.id AS msdid ,msd.name AS msdname ,md.id AS mdid,md.name AS mdname,mpw.id AS mpwid,mpw.name AS mpwname FROM members m
LEFT JOIN master_sub_departments msd ON msd.id=m.serving_sub_department_id
LEFT JOIN master_designations md ON md.id =m.designation_id
LEFT JOIN master_place_works mpw ON mpw.id = m.work_location_id";*/
         

            $members = Member::all();
            $subDepartments = MasterSubDepartment::all();
            $designations = MasterDesignation::all();
            $placeWorks = MasterPlaceWork::all();
            
            // Return the JSON responses for each data set
            $response = [
                'members' => $members,
                'subDepartments' => $subDepartments,
                'designations' => $designations,
                'placeWorks' => $placeWorks,
            ];
           
          
return response()->json($response);
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
