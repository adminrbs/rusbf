<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class LimitlessController extends Controller
{
    public function index(Request $request){
        if(view()->exists($request->path())){
            return view($request->path());
        }
        return view('errors.404');
    }


    public function save(){
        $employee = new Employee();
        $employee->name = "Sampath";
        $employee->save();
    }


    public function update($id){
        $employee = Employee::find($id);
        $employee->name = "Sampath xxx";
        $employee->update();
    }

    
}
