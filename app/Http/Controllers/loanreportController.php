<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RepoEldo\ELD\ReportViewer;

class loanreportController extends Controller
{
    public function loanReport()
    {
        try {
            $query = 'SELECT m.full_name,m.member_number
            FROM members m';

            $result = DB::select($query);

            $reportViwer = new ReportViewer();



           // $reportViwer->addParameter("loan", [$result]);




            $reportViwer->addParameter('companyName', CompanyDetailsController::CompanyName());
            $reportViwer->addParameter('companyAddress', CompanyDetailsController::CompanyAddress());
            $reportViwer->addParameter('companyNumber', CompanyDetailsController::CompanyNumber());
            $reportViwer->addParameter('companylogo', CompanyDetailsController::companyimage());




            return $reportViwer->viewReport('Lon.json');
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
