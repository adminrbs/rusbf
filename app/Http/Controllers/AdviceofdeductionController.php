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

                  
                    $query = "SELECT
                    COALESCE(members.id, contributions.member_id, loans.member_id) AS member_id,
                    members.member_number,
                    members.full_name,
                    members.computer_number,
                    members.payroll_number,
                     COALESCE(SUM(contributions.total_amount_for_month_year), 0) +
                    COALESCE(SUM(loans.total_amount_for_month_year), 0) AS total_amount_for_month_year,
                    COALESCE(contributions.year, loans.year) AS year
                    
                FROM (
                   
                    SELECT
                        member_id,
                        year,
                        month,
                        SUM(`amount`) AS total_amount_for_month_year
                    FROM `member_contribution_ledgers`
                    GROUP BY `member_id`, `year`, `month`
                ) AS contributions
                LEFT JOIN (
                  
                    SELECT
                        MLL.member_id,
                        MLL.year,
                        MLL.month,
                        COALESCE(SUM(MLL2.amount + MLL2.interest_amount), 0) AS total_amount_for_month_year
                    FROM member_loan_ledgers MLL
                    LEFT JOIN member_loan_ledgers MLL2 ON
                        MLL.member_id = MLL2.member_id
                        AND MLL.year = MLL2.year
                        AND MLL.month = MLL2.month
                    WHERE MLL.member_id = MLL2.member_id
                    GROUP BY MLL.member_id, MLL.year, MLL.month
                ) AS loans ON contributions.member_id = loans.member_id
                           AND contributions.year = loans.year
                           AND contributions.month = loans.month
                LEFT JOIN members ON members.id = COALESCE(loans.member_id, contributions.member_id)
               ";
    
    
    
                    $quryModify = "";
                    if ($selectedepartment != null) {
                        $quryModify .= "  members.serving_sub_department_id ='" . $selectedepartment . "'AND";
                    }
                    
            
                    if ($selectedesignation != null) {
                        $quryModify .= "  members.designation_id ='" . $selectedesignation . "'AND";
                    }
                   
            
            
                    if ($selectedecomputernumber != null) {
                        $quryModify .= " members.computer_number ='" . $selectedecomputernumber . "'AND";
                    }
                    
            
                    if ($selectedelocation != null) {
                        $quryModify .= " members.work_location_id ='" . $selectedelocation . "' AND";
                    }
                   
            
            
                    if ($selecteyear != null) {
                        $quryModify .= " contributions.year, loans.year ='" . $selecteyear . "'AND";
                    }
                   
            
                    if ($selectemonth != null) {
                        $quryModify .= " contributions.month, loans.month" . $selectemonth . "'AND";
                    }
    
                    if ($quryModify != "") {
                        $quryModify = rtrim($quryModify, 'AND OR ');
                        $query = $query . " where " . $quryModify . 'GROUP BY members.member_number,
                        members.full_name,
                        members.computer_number,
                        members.payroll_number,
                        COALESCE(contributions.year, loans.year),
                        COALESCE(contributions.month, loans.month)';
                    }
    
                    //$query = $query . ' GROUP BY D.customer_id';
    
    
                    //$query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);
                    //dd($query);
                    $result = DB::select($query);
    
                    $reportViwer = new ReportViewer();
                
    
    
                    $reportViwer->addParameter("tabledata", $result);
                    //$reportViwer->addParameter("Customerledger_tabaledata", $result);
                } else {
    
                    $query = "SELECT
                    COALESCE(MAX(members.id), MAX(contributions.member_id), MAX(loans.member_id)) AS member_id,
                    members.member_number,
                    members.full_name,
                    members.computer_number,
                    members.payroll_number,
                    COALESCE(SUM(contributions.total_amount_for_month_year), 0) +
                    COALESCE(SUM(loans.total_amount_for_month_year), 0) AS total_amount_for_month_year,
                    COALESCE(contributions.year, loans.year) AS year,
                    COALESCE(contributions.month, loans.month) AS month
                    
                FROM (
                    SELECT
                        member_id,
                        year,
                        month,
                        SUM(`amount`) AS total_amount_for_month_year
                    FROM `member_contribution_ledgers`
                    GROUP BY `member_id`, `year`, `month`
                ) AS contributions
                LEFT JOIN (
                    SELECT
                        MLL.member_id,
                        MLL.year,
                        MLL.month,
                        COALESCE(SUM(MLL2.amount + MLL2.interest_amount), 0) AS total_amount_for_month_year
                    FROM member_loan_ledgers MLL
                    LEFT JOIN member_loan_ledgers MLL2 ON
                        MLL.member_id = MLL2.member_id
                        AND MLL.year = MLL2.year
                        AND MLL.month = MLL2.month
                    WHERE MLL.member_id = MLL2.member_id
                    GROUP BY MLL.member_id, MLL.year, MLL.month
                ) AS loans ON contributions.member_id = loans.member_id
                           AND contributions.year = loans.year
                           AND contributions.month = loans.month
                LEFT JOIN members ON members.id = COALESCE(loans.member_id, contributions.member_id)";
        
        $quryModify = ""; // Your existing modification code...
        
        if ($quryModify != "") {
            $query = $query . " WHERE " . $quryModify . ' GROUP BY members.member_number,
                            members.full_name,
                            members.computer_number,
                            members.payroll_number,
                            COALESCE(contributions.year, loans.year),
                            COALESCE(contributions.month, loans.month)';
        } else {
            $query = $query . ' GROUP BY members.member_number,
                            members.full_name,
                            members.computer_number,
                            members.payroll_number,
                            COALESCE(contributions.year, loans.year),
                            COALESCE(contributions.month, loans.month)';
        }
        
        // Rest of your code...
dd($query);
        $result = DB::select($query);
        //dd($result);
        
    
                    $reportViwer = new ReportViewer();
                   
    
                    //$reportViwer = new ReportViewer();
                    $reportViwer->addParameter("tabledata",$result);
                }

    
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