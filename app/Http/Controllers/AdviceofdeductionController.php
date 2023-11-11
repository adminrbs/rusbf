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

class AdviceofdeductionController extends Controller
{
    public function adviceofdeductionReport($search)

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
    
                if ($nonNullCount > 1) {

                    $quryModify1 = "";
                    $quryModify2 = "";
                    if ($selecteyear != null) {
                        $quryModify1 .= " MCL.`year`= '".$selecteyear."' AND ";
                        $quryModify2 .= " MLL.`year`= '".$selecteyear."' AND ";
                    }
                   
            
                    if ($selectemonth != null) {
                        $quryModify1 .= " MCL.`month`= '".$selectemonth."' AND";
                        $quryModify2 .= " MLL.`month`= '".$selectemonth."' AND";
                    }
                    if ($selectedepartment != null) {
                        $quryModify1 .= "  M.serving_sub_department_id= '".$selectedepartment."' AND";
                        $quryModify2 .= "  M.serving_sub_department_id= '".$selectedepartment."' AND";
                    }
                    $quryModify1 = preg_replace('/\W\w+\s*(\W*)$/', '$1', $quryModify1);
                    $quryModify2 = preg_replace('/\W\w+\s*(\W*)$/', '$1', $quryModify2);
                  
                    $query = "SELECT 
 ROW_NUMBER() OVER (ORDER BY D.member_id) AS serial_number,
D.member_id ,MMB.member_number,
D.member_id , MMB.name_initials  , MMB.computer_number , MMB.cabinet_number  , D.Amount     FROM 

                    (SELECT AD.member_id , SUM(AD.Amount) AS Amount FROM 
                    
                    ( SELECT  MCL.member_id , SUM(MCL.amount) AS Amount  FROM member_contribution_ledgers MCL 
                    LEFT JOIN members M ON M.id=MCL.member_id 
                    WHERE ".$quryModify1."
                    GROUP BY member_id    
                    
                    UNION ALL 
                    
                    SELECT  MLL.member_id , SUM(MLL.amount+MLL.interest_amount) AS Amount  FROM member_loan_ledgers  MLL 
                    LEFT JOIN members M ON M.id=MLL.member_id 
                    WHERE ".$quryModify2."  
                    GROUP BY member_id  ) AD    
                    GROUP BY AD.member_id ) D 
                    
                    LEFT JOIN members MMB  ON MMB.id=D.member_id";
    
    
    
                    //$query = $query . ' GROUP BY D.customer_id';
    
    
                    //$query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);
                    ///dd($query);
                    $result = DB::select($query);
    
                    $reportViwer = new ReportViewer();
                
    
    
                    $reportViwer->addParameter("tabledata", $result);
                    //$reportViwer->addParameter("Customerledger_tabaledata", $result);
                } else {

                    $quryModify1 = " WHERE ";
                    $quryModify2 = " WHERE ";
if($selecteyear == null && $selectemonth == null && $selectedepartment == null){
    $quryModify1 = " ";
    $quryModify2 = " ";
}
                    if ($selecteyear != null) {
                        $quryModify1 .= " MCL.`year`= '".$selecteyear."' AND";
                        $quryModify2 .= " MLL.`year`= '".$selecteyear."' AND ";
                    }
                   
            
                    if ($selectemonth != null) {
                        $quryModify1 .= " MCL.`month`= '".$selectemonth."' AND ";
                        $quryModify2 .= " MLL.`month`= '".$selectemonth."' AND ";
                    }
                    if ($selectedepartment != null) {
                        $quryModify1 .= "  M.serving_sub_department_id= '".$selectedepartment."' AND ";
                        $quryModify2 .= "  M.serving_sub_department_id= '".$selectedepartment."' AND";
                    }
                    $quryModify1 = preg_replace('/\W\w+\s*(\W*)$/', '$1', $quryModify1);
                    $quryModify2 = preg_replace('/\W\w+\s*(\W*)$/', '$1', $quryModify2);
                  
                    $query = "SELECT 
                    ROW_NUMBER() OVER (ORDER BY D.member_id) AS serial_number,
                   D.member_id ,MMB.member_number,
                   D.member_id , MMB.name_initials  , MMB.computer_number , MMB.cabinet_number  , D.Amount     FROM 
                   
                                       (SELECT AD.member_id , SUM(AD.Amount) AS Amount FROM 
                                       
                                       ( SELECT  MCL.member_id , SUM(MCL.amount) AS Amount  FROM member_contribution_ledgers MCL 
                                       LEFT JOIN members M ON M.id=MCL.member_id 
                                        ".$quryModify1."
                                       GROUP BY member_id    
                                       
                                       UNION ALL 
                                       
                                       SELECT  MLL.member_id , SUM(MLL.amount+MLL.interest_amount) AS Amount  FROM member_loan_ledgers  MLL 
                                       LEFT JOIN members M ON M.id=MLL.member_id 
                                      ".$quryModify2."  
                                       GROUP BY member_id  ) AD    
                                       GROUP BY AD.member_id ) D 
                                       
                                       LEFT JOIN members MMB  ON MMB.id=D.member_id";
        
       
       
        

       
      
        
        // Rest of your code...
//dd($query);
        $result = DB::select($query);
        //dd($result);
        
    
                    $reportViwer = new ReportViewer();
                   
    
                    //$reportViwer = new ReportViewer();
                    $reportViwer->addParameter("tabledata",$result);
                }

                $selectemonthN = $searchOption[5]->selectemonth;
               
$monthNames = [
    1 => "January",
    2 => "February",
    3 => "March",
    4 => "April",
    5 => "May",
    6 => "June",
    7 => "July",
    8 => "August",
    9 => "September",
    10 => "October",
    11 => "November",
    12 => "December",
];

$selectemonth = isset($monthNames[$selectemonthN]) ? $monthNames[$selectemonthN] : "";

    
    
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
    
    
                return $reportViwer->viewReport('AdviceofdeductionReport.json');
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

}


/*

 if ($selectedepartment != null) {
            $quryModify .= "  members.serving_sub_department_id ='" . $selectedepartment . "'";
        }
        

        if ($selectedesignation != null) {
            $quryModify .= "  members.designation_id ='" . $selectedesignation . "'";
        }
       


        if ($selectedecomputernumber != null) {
            $quryModify .= " members.computer_number ='" . $selectedecomputernumber . "'";
        }
        

        if ($selectedelocation != null) {
            $quryModify .= " members.work_location_id ='" . $selectedelocation . "' ";
        }
       


        if ($selecteyear != null) {
            $quryModify .= " contributions.year, loans.year ='" . $selecteyear . "'";
        }
       

        if ($selectemonth != null) {
            $quryModify .= " contributions.month, loans.month" . $selectemonth . "'";
        }        
*/