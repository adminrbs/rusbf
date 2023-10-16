<?php

namespace App\Http\Controllers;

use App\Models\MasterDesignation;
use App\Models\MasterPlaceWork;
use App\Models\MasterSubDepartment;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RepoEldo\ELD\ReportViewer;

class loanreportController extends Controller
{
    public function loanReport($search)
    {
        try {
            $searchOption = json_decode($search);
            $selectedepartment = $searchOption[0]->selectedepartment;
            $selectedesignation = $searchOption[1]->selectedesignation;
            $selectedecomputernumber = $searchOption[2]->selectedecomputernumber;
            $selectedelocation = $searchOption[3]->selectedelocation;
            $selecteyear = $searchOption[4]->selecteyear;
            $selectemonth = $searchOption[5]->selectemonth;
            //dd($searchOption);
            $nonNullCount = 0;

            if ($searchOption !== null) {

                if ($searchOption[0]->selectedepartment !== null) {
                    $nonNullCount++;
                }
                if ($searchOption[1]->selectedesignation !== null) {
                    $nonNullCount++;
                }
                if ($searchOption[2]->selectedecomputernumber !== null) {
                    $nonNullCount++;
                }
                if ($searchOption[3]->selectedelocation !== null) {
                    $nonNullCount++;
                }
                if ($searchOption[4]->selecteyear !== null) {
                    $nonNullCount++;
                }
                if ($searchOption[5]->selectemonth !== null) {
                    $nonNullCount++;
                }
            }
//dd($nonNullCount);

            $reportViwer = new ReportViewer();


            if ($searchOption !== null) {
                $department = $this->gedepartment($selectedepartment);
                $departmentname = '';
                if ($department != null) {
                    $departmentname = $department->name;
                }

                $designation = $this->getdesignation($selectedesignation);
                $designationname = '';
                if ($designation != null) {
                    $designationname = $designation->name;
                }
                $computernumber = $this->getcomputernumber($selectedecomputernumber);
                $computernum = '';
                if ($computernumber != null) {
                    $computernum = $computernumber->computer_number;
                }

                $location = $this->getlocation($selectedelocation);
                $locationrnum = '';
                if ($location != null) {
                    $locationrnum = $location->name;
                }

                if ($nonNullCount > 1) {
                    $filterLabel = '';
                    if ($nonNullCount > 1) {
                        $filterLabel .= "For";
                    }
                    if ($selecteyear !== null) {
                        // Add a separator if needed
                        if ($filterLabel !== '') {
                            $filterLabel .= ' ';
                        }
                        $filterLabel .= " Year: $selecteyear and";
                    }


                    if ($selectemonth !== null) {
                        $filterLabel .= " Month: $selectemonth and ";
                    }

                    if ($selectedepartment !== null) {
                        // Add a separator if needed
                        if ($filterLabel !== '') {
                            $filterLabel .= ' ';
                        }
                        $filterLabel .= " Serving Sub Department: $departmentname and";
                    }
                    if ($selectedesignation !== null) {
                        // Add a separator if needed
                        if ($filterLabel !== '') {
                            $filterLabel .= ' ';
                        }
                        $filterLabel .= " Designation: $designationname and";
                    }

                    if ($selectedecomputernumber !== null) {
                        // Add a separator if needed
                        if ($filterLabel !== '') {
                            $filterLabel .= ' ';
                        }
                        $filterLabel .= " computer Number: $computernum and";
                    }
                    if ($selectedelocation !== null) {
                        // Add a separator if needed
                        if ($filterLabel !== '') {
                            $filterLabel .= ' ';
                        }
                        $filterLabel .= " Work Location: $locationrnum and";
                    }
                    if (!empty($filterLabel)) {
                        $filterLabel = rtrim($filterLabel, 'and ');

                        $reportViwer->addParameter("filter", $filterLabel);
                    }
                } else {

                    if (
                        $selectedepartment == null && $selectedesignation == null && $selectedecomputernumber == null
                        && $selectedelocation == null && $selecteyear == null &&  $selectemonth ==null
                    ) {
                        $filterLabel = "";
                    } elseif ($selecteyear !== null) {
                        $filterLabel = "For: Year: $selecteyear";
                    } elseif ($selectemonth !== null) {
                        $filterLabel = "For: Month: $selectemonth";
                    } elseif ($selectedepartment !== null) {
                        $filterLabel = "For: Serving Sub Department: $departmentname ";
                    } elseif ($selectedesignation !== null) {
                        $filterLabel = "For: Designation: $designationname";
                    } elseif ($selectedecomputernumber !== null) {
                        $filterLabel = "For: computer Number: $computernum";
                    } elseif ($selectedelocation !== null) {
                        $filterLabel = "For: Work Location: $locationrnum";
                    }

                    $reportViwer->addParameter("filter", $filterLabel);
                }
            }










            $reportViwer->addParameter('companyName', CompanyDetailsController::CompanyName());
            $reportViwer->addParameter('companyAddress', CompanyDetailsController::CompanyAddress());
            $reportViwer->addParameter('companyNumber', CompanyDetailsController::CompanyNumber());
            $reportViwer->addParameter('companylogo', CompanyDetailsController::companyimage());

            $length =  (strlen($filterLabel) / 90);
            $i = floor($length);
            $i2 = 0;
            if (($length - $i) > 0) {
                $i2++;
            }
            $label_height = (($i + $i2) * 20);

            //dd($length . " " . (strlen($filterLabel)));
            $reportViwer->addParameter('hight', $label_height);


            return $reportViwer->viewReport('Lon.json');
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function gedepartment($selectedepartment)
    {
        $department = MasterSubDepartment::find($selectedepartment);
        if ($department) {
            return $department;
        }
        return null;
    }
    public function getdesignation($selectedesignation)
    {
        $designation = MasterDesignation::find($selectedesignation);
        if ($designation) {
            return $designation;
        }
        return null;
    }

    public function getcomputernumber($selectedecomputernumber)
    {
        $computernumber = Member::find($selectedecomputernumber);
        if ($computernumber) {
            return $computernumber;
        }
        return null;
    }
    public function getlocation($selectedelocation)
    {
        $location = MasterPlaceWork::find($selectedelocation);
        if ($location) {
            return $location;
        }
        return null;
    }

// filter hidden 

public function filterhidden(Request $request,$id)
{
    $jsonData = json_decode($request->getContent(), true);

    $year = $jsonData['year'];
$month = $jsonData['month'];
$subDepartments = $jsonData['subDepartments'];
$designation = $jsonData['designation'];
$computernumber = $jsonData['computernumber'];
$worklocation = $jsonData['worklocation'];


}
}
