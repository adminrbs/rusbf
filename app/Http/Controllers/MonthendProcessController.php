<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Exception;
use Illuminate\Http\Request;

class MonthendProcessController extends Controller
{
    //
    public function getCurrentYearMonth()
    {
        try {
            return response()->json(["status" => true, "data" => GlobalSetting::find(1)]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }

    public function monthend_process()
    {
        try {
            $globalSetting = GlobalSetting::find(1);
            if ($globalSetting) {
                $year = $globalSetting->current_year;
                $month = ($globalSetting->current_month + 1);
                if ($month > 12) {
                    $month = 1;
                    $year = ($year + 1);
                }
                $globalSetting->current_year = $year;
                $globalSetting->current_month = $month;
                $globalSetting->update();
            }
            return response()->json(["status" => true, "data" => null]);
        } catch (Exception $exception) {
            return response()->json(["status" => false, "data" => $exception]);
        }
    }
}
