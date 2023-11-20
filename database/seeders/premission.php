<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class premission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Model::unguard();
        DB::table('permissions')->insert([
            //member information
            ['name' => 'Member Information', 'slug' => 'member_information', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //1
            ['name' => 'Members', 'slug' => 'members', 'sub' => '1', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //2
            ['name' => 'Setting', 'slug' => 'setting', 'sub' => '1', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //3
            ['name' => 'Designation', 'slug' => 'designation', 'sub' => '3', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //4
            ['name' => 'Place of work', 'slug' => 'place_of_work', 'sub' => '3', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //5
            ['name' => 'Sub Department', 'slug' => 'sub_department', 'sub' => '3', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //6
            ['name' => 'Place of Payeoll Preparation', 'slug' => 'place_of_payeroll', 'sub' => '3', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //7

            // contribution
            ['name' => 'Contribution', 'slug' => 'contribution', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //8
            ['name' => 'Member Contribution', 'slug' => 'member_contribution', 'sub' => '8', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //9
            ['name' => 'Contribution Ledger', 'slug' => 'contribution_ledger', 'sub' => '8', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //10
            ['name' => 'Setting', 'slug' => 'setting', 'sub' => '8', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //11
            ['name' => 'Contribution', 'slug' => 'contribution_setting', 'sub' => '11', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //12

            // Loan
            ['name' => 'Loan', 'slug' => 'loan', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //13
            ['name' => 'Loan Request', 'slug' => 'loan_request', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //14
            ['name' => 'Loan Request Approval', 'slug' => 'loan_request_approval', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //15
            ['name' => 'Member Loan', 'slug' => 'member_loan', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //16
            ['name' => 'Loan Ledger', 'slug' => 'loan_ledger', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //17
            ['name' => 'Recipet', 'slug' => 'recipt', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //18
            ['name' => 'Setting', 'slug' => 'setting', 'sub' => '13', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //19
            ['name' => 'Loan', 'slug' => 'loan_setting', 'sub' => '19', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //20


            // donations_and_rativity
            ['name' => 'Donations & Grativity', 'slug' => 'donations_and_grativity', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //21
            ['name' => 'Death Grativity Request', 'slug' => 'donations_and_grativity_request', 'sub' => '21', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //22
            ['name' => 'Death Grativity Approval', 'slug' => 'donations_and_grativity_approval', 'sub' => '21', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //23
            ['name' => 'Setting', 'slug' => 'setting', 'sub' => '21', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //24
            ['name' => 'Donations', 'slug' => 'donation', 'sub' => '24', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //25

            // Payment
            ['name' => 'Payment', 'slug' => 'payment', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //26

            // Report
            ['name' => 'Report', 'slug' => 'report', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //27
            ['name' => 'Member information Sheet', 'slug' => 'member_information_sheet', 'sub' => '27', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //28
            ['name' => 'Advice of dedction', 'slug' => 'advice_of_dedction', 'sub' => '27', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //29

            // Tools
            ['name' => 'Tools', 'slug' => 'tools', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //30
            ['name' => 'Process Loan', 'slug' => 'process_loan', 'sub' => '30', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //31
            ['name' => 'Process Contribution', 'slug' => 'process_contribution', 'sub' => '30', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //32
            ['name' => 'Month End Process', 'slug' => 'month_end_process', 'sub' => '30', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //33

 // Tools
 ['name' => 'Settings', 'slug' => 'setting', 'sub' => 'null', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //34
 ['name' => 'User Roles', 'slug' => 'user_role', 'sub' => '34', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //35
 ['name' => 'User List', 'slug' => 'user_list', 'sub' => '34', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //36

 // Permission
 ['name' => 'Permission', 'slug' => 'permission', 'sub' => '34', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //37
 //['name' => 'User Roles', 'slug' => 'user_role', 'sub' => '34', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //38
 //['name' => 'User List', 'slug' => 'user_list', 'sub' => '34', 'action' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], //39
 


        ]);
    }
}
