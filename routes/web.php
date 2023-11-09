<?php

use App\Http\Controllers\AdviceofdeductionController;
use App\Http\Controllers\contributionandLoanFilterController;
use App\Http\Controllers\contributnController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeathGratuityRequestsController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MasterPlaceWorkController;
use App\Http\Controllers\MasterSubDepartmentController;
use App\Http\Controllers\MasterPayrollController;
use App\Http\Controllers\MasterDesignationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LimitlessController;
use App\Http\Controllers\loanreportController;
use App\Http\Controllers\loneManagementController;
use App\Http\Controllers\member_contributionController;
use App\Http\Controllers\MemberContributionLedgerProcessController;
use App\Http\Controllers\MemberContributionLedgerProcessListController;
use App\Http\Controllers\MemberLoanController;
use App\Http\Controllers\MemberLoanLedgerController;
use App\Http\Controllers\memberLoanLedgerListController;
use App\Http\Controllers\memberreportController;
use App\Http\Controllers\MembersLoanRequestController;
use App\Models\member_contribution;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

/*
Route::get('/', function () {
    Auth::attempt(['email' => 'admin@themesbrand.com', 'password' => '12345678'], true);

    $notificationData = [
        'data' => "This is Notification",
        'link' => "/"
    ];
    //User::find(1)->notify(new UserNotification($notificationData));
    return view('dashboard');
});
*/


Route::get('/customer', function () {
    return view('customer');
});

Route::get('/customer2', function () {
    return view('customer2');
});

Route::get('/customer_form', function () {
    return view('form');
});

/*
Route::get('/readNotification/{id}', function ($id) {
    $notification = auth()->user()->notifications()->where('id', $id)->first();

    if ($notification) {
        $notification->markAsRead();
        return redirect($notification->data['link']);
    }
    return redirect('/');
});
*/

Auth::routes();

Route::get('/save', [LimitlessController::class, 'save']);
Route::get('/update/{id}', [LimitlessController::class, 'update']);
Route::post('/CustomerController/saveCustomer',[CustomerController::class,'saveCustomer']);
Route::post('/FormController/saveCustomer',[FormController::class,'saveCustomer']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/submitForm', [LoginController::class,'loginForm']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//members routes
Route::get('/members', function () {
    return view('view_all_members');
});
Route::get('/member_form', [MemberController::class, 'view_member_form']);
Route::get('/get_member_data/{id}', [MemberController::class, 'get_member_data']);
Route::post('/member_form/update', [MemberController::class, 'update']);
Route::post('/save_member', [MemberController::class, 'save']);
Route::get('/get_all_members', [MemberController::class, 'get_all_members']);
Route::delete('/delete_member/{id}', [MemberController::class, 'delete']);

// Master Data - Designation
Route::get('/master_designation', function () {
    return view('designation');
});
Route::post('/save_designation', [MasterDesignationController::class, 'save_designation']);
Route::get('/get_all_designations', [MasterDesignationController::class, 'get_all_designations']);
Route::get('/get_designation_data/{id}', [MasterDesignationController::class, 'get_designation_data']);
Route::post('/master_designation/update', [MasterDesignationController::class, 'update']);
Route::delete('/delete_designation/{id}', [MasterDesignationController::class, 'delete']);
Route::post('/designationStatus/{id}', [MasterDesignationController::class, 'designationStatus']);

// Master Data - Place of Work
Route::get('/master_place_of_work', function () {
    return view('place_of_work');
});
Route::post('/save_place_of_work', [MasterPlaceWorkController::class, 'save_place_of_work']);
Route::get('/get_all_place_of_work', [MasterPlaceWorkController::class, 'get_all_place_of_work']);
Route::get('/get_place_of_work_data/{id}', [MasterPlaceWorkController::class, 'get_place_of_work_data']);
Route::post('/master_place_of_work/update', [MasterPlaceWorkController::class, 'update']);
Route::delete('/delete_place_of_work/{id}', [MasterPlaceWorkController::class, 'delete']);
Route::post('/place_of_workStatus/{id}', [MasterPlaceWorkController::class, 'place_of_workStatus']);

// Master Data - Serving Sub-Department
Route::get('/master_sub_department', function () {
    return view('serving_sub_department');
});
Route::post('/save_department', [MasterSubDepartmentController::class, 'save_department']);
Route::get('/get_all_departments', [MasterSubDepartmentController::class, 'get_all_departments']);
Route::get('/get_department_data/{id}', [MasterSubDepartmentController::class, 'get_department_data']);
Route::post('/master_department/update', [MasterSubDepartmentController::class, 'update']);
Route::delete('/delete_department/{id}', [MasterSubDepartmentController::class, 'delete']);
Route::post('/departmentStatus/{id}', [MasterSubDepartmentController::class, 'departmentStatus']);

// Master Data - Place of Payroll
Route::get('/master_place_of_payroll', function () {
    return view('place_of_payroll');
});
Route::post('/save_payroll', [MasterPayrollController::class, 'save_payroll']);
Route::get('/get_all_payroll', [MasterPayrollController::class, 'get_all_payroll']);
Route::get('/get_payroll_data/{id}', [MasterPayrollController::class, 'get_payroll_data']);
Route::post('/master_payroll/update', [MasterPayrollController::class, 'update']);
Route::delete('/delete_payroll/{id}', [MasterPayrollController::class, 'delete']);
Route::post('/payrollStatus/{id}', [MasterPayrollController::class, 'payrollStatus']);

//Settings- Roles
Route::get('/user_role_list', function () {
    return view('role_list');
});
Route::post('/save_user_role', [RoleController::class, 'save_user_role']);
Route::get('/get_user_roles', [RoleController::class, 'get_user_roles']);
Route::get('/get_role_data/{id}', [RoleController::class, 'get_role_data']);
Route::post('/user_role/update', [RoleController::class, 'update']);
Route::delete('/user_role/{id}', [RoleController::class, 'delete']);
Route::post('/user_role_status/{id}', [RoleController::class, 'user_role_status']);

//Settings- User list
Route::get('/get_user_role', [UserController::class, 'get_user_role']);
Route::post('/save_user', [UserController::class, 'save_user']);
Route::get('/view_users_list', [UserController::class, 'view_users_list']);
Route::get('/load_users_list', [UserController::class, 'load_users_list']);
Route::get('/get_user_data/{id}', [UserController::class, 'get_user_data']);
Route::post('/update_user/{id}',[UserController::class,'update_user']);
Route::delete('/deleteusers/{id}',[UserController::class,'deleteusers']);

// Change Password 
Route::post('/change_password/{id}', [UserController::class, 'change_password']);

// Lone Management
Route::get('/loneManagement', function () {
    return view('loanManagement');
});
Route::post('/loansave',[loneManagementController::class,'loansave']);
Route::get('/loneallData',[loneManagementController::class,'loanallData']);
Route::get('/getlone/{id}',[loneManagementController::class,'getloan']);
Route::post('/getloneupdate/{id}',[loneManagementController::class,'getloneupdate']);
Route::delete('/deletelone/{id}',[loneManagementController::class,'deletelone']);
Route::post('/cbxlonee/{id}',[loneManagementController::class,'cbxlonee']);

Route::post('/lonetermsave/{id}',[loneManagementController::class,'lonetermsave']);
Route::get('/lonetermAllData/{id}',[loneManagementController::class,'lonetermAllData']);
Route::get('/getloneterm/{id}',[loneManagementController::class,'getloneterm']);
Route::post('/updateloneterm/{id}',[loneManagementController::class,'updateloneterm']);
Route::delete('/deleteloneterm/{id}',[loneManagementController::class,'deleteloneterm']);
Route::get('/getloneAllData/{id}',[loneManagementController::class,'getloneAllData']);

// contribution
Route::get('/contribution', function () {
    return view('contribution');
});

Route::post('/save_contribution',[contributnController::class,'save_contribution']);
Route::get('/allcontributedata',[contributnController::class,'allcontributedata']);
Route::get('/getcontribute/{id}',[contributnController::class,'getcontribute']);
Route::post('/update_contribution/{id}',[contributnController::class,'update_contribution']);
Route::delete('deletecontribute/{id}',[contributnController::class,'deletecontribute']);
Route::post('/cbxcontribute/{id}',[contributnController::class,'cbxcontribute']);

//member_contribution
Route::get('/member_contribution', function () {
    return view('member_contribution');
});
Route::get('/membercontributedata/{id}',[member_contributionController::class,'membercontributedata']);
Route::get('/memberNumber/{id}',[member_contributionController::class,'memberNumber']);
Route::get('/computerNumber/{id}',[member_contributionController::class,'computerNumber']);
Route::get('/fullName/{id}',[member_contributionController::class,'fullName']);
Route::get('/imageloard/{id}',[member_contributionController::class,'imageloard']);
Route::get('/amountset/{id}',[member_contributionController::class,'amountset']);

Route::post('/save_memberContribution',[member_contributionController::class,'save_memberContribution']);
Route::post('/deleteMembercontribution/{id}',[member_contributionController::class,'deleteMembercontribution']);




// members_loan_request

Route::get('/members_loan_request', function () {
    return view('members_loan_request');
});
Route::get('/members_loan_form', function () {
    return view('members_loan_requestform');
});
Route::get('/members_loan_request_Approvel', function () {
    return view('members_loan_requestform_ApprovelList');
});
Route::get('/memberShip/{id}',[MembersLoanRequestController::class,'memberShip']);
Route::get('/memberShipdesignation/{id}',[MembersLoanRequestController::class,'MembersLoanRequestController']);
Route::get('/getalldetails/{memberid}/{id}',[MembersLoanRequestController::class,'getalldetails']);
Route::post('/save_memberlonrequest',[MembersLoanRequestController::class,'save_memberlonrequest']);
Route::get('/allmemberlonrequest',[MembersLoanRequestController::class,'allmemberlonrequest']);
Route::get('/getmemberlone/{id}',[MembersLoanRequestController::class,'getmemberlone']);
Route::post('/update_memberlonrequest/{id}',[MembersLoanRequestController::class,'update_memberlonrequest']);
Route::delete('deletememberlone/{id}',[MembersLoanRequestController::class,'deletememberlone']);
Route::post('/rejectRequest/{id}',[MembersLoanRequestController::class,'rejectRequest']);
Route::post('/approveRequest/{id}',[MembersLoanRequestController::class,'approveRequest']);
Route::post('/saveattachment/{id}',[MembersLoanRequestController::class,'saveattachment']);
Route::get('/getAttachment/{id}',[MembersLoanRequestController::class,'getAttachment']);
Route::get('/viewAttachment/{id}',[MembersLoanRequestController::class,'viewAttachment']);
Route::delete('deletattachment/{id}',[MembersLoanRequestController::class,'deletattachment']);
Route::get('/getlone',[MembersLoanRequestController::class,'getlone']);
Route::get('/getterm/{id}',[MembersLoanRequestController::class,'getterm']);

Route::get('/membershipno/{id}',[MembersLoanRequestController::class,'membershipno']);

//approval
Route::get('allmemberlonrequestapprovel',[MembersLoanRequestController::class,'allmemberlonrequestapprovel']);



//Member Contribution ledger process
Route::get('/member_contribution_ledger_process', function () {
    return view('member_contribution_ledger_process');
});
Route::get('/getCurrentYearMonth',[MemberContributionLedgerProcessController::class,'getCurrentYearMonth']);
Route::post('/member_contribution_ledger_process',[MemberContributionLedgerProcessController::class,'member_contribution_ledger_process']);

//Member Contribution ledger process list
Route::get('/member_contribution_ledger_process_list', function () {
    return view('member_contribution_ledger_process_list');
});
Route::get('/getMemberContributions/{filters}',[MemberContributionLedgerProcessListController::class,'getMemberContributions']);
Route::get('/getMembers',[MemberContributionLedgerProcessListController::class,'getMembers']);

// member_loan

Route::get('/member_loan',function(){
return view('member_loan');
});
Route::get('/memberloandata/{id}',[MemberLoanController::class,'memberloandata']);
Route::post('/memberlonestatus/{id}',[MemberLoanController::class,'memberlonestatus']);


//Loan Process
Route::get('/loan_process', function () {
    return view('loan_process');
});
Route::post('/member_loan_ledger_process',[MemberLoanLedgerController::class,'member_loan_ledger_process']);

// Report
Route::get('/memberReport',function(){
return view('memberreport');
});
Route::get('/getmembersreport',[memberreportController::class,'getmembersreport']);
Route::get('/loanReport/{search}',[loanreportController::class,'loanReport']);
Route::post('/filterhidden/{id}',[loanreportController::class,'filterhidden']);

// lone ledger
Route::get('/member_loan_ledger_list', function () {
    return view('member_loan_ledger_list');
});
Route::get('getMemberloan',[memberLoanLedgerListController::class,'getMemberloan']);
Route::post('/allmemberloanledgerdata',[memberLoanLedgerListController::class,'allmemberloanledgerdata']);

Route::get('/contributionAndloanFilter',function(){
return view('contributionAndloanFilter');
});
Route::get('/getmember',[contributionandLoanFilterController::class,'getmember']);
Route::post('/getcontribution/{id}',[contributionandLoanFilterController::class,'getcontribution']);
Route::post('/getLoan/{id}',[contributionandLoanFilterController::class,'getmemberloandata']);
Route::get('/subdepartment/{id}',[contributionandLoanFilterController::class,'subdepartment']);
Route::get('/subserveDepartmentmember/{id}',[contributionandLoanFilterController::class,'subserveDepartmentmember']);

// master donation 

Route::get('/donation',function(){
return view('donation');
});
Route::post('/save_donetion',[DonationController::class,'save_donetion']);
Route::get('/get_donetion',[DonationController::class,'get_donetion']);
Route::get('/get_donetion_data/{id}',[DonationController::class,'get_donetion_data']);
Route::post('/update_donetion',[DonationController::class,'update_donetion']);
Route::delete('/delete_donetion/{id}',[DonationController::class,'delete_donetion']);
Route::post('/cbxdonation/{id}',[DonationController::class,'cbxdonation']);


//  Death_gratuity_requests

Route::get('/Death_gratuity_requests',function(){
return view('death_gratuity_requests');
});

Route::get('/Death_gratuity_all_requests',function(){
    return view('death_gratuity_requests_list');
    });
Route::get('/alldatamemberShip/{id}',[DeathGratuityRequestsController::class,'alldatamemberShip']);
Route::get('/getPosition',[DeathGratuityRequestsController::class,'getPosition']);
Route::get('/getdepartmentsection',[DeathGratuityRequestsController::class,'getdepartmentsection']);
Route::post('/saveDeathgratuityrequests',[DeathGratuityRequestsController::class,'saveDeathgratuityrequests']);
Route::get('/alldeathgratuity',[DeathGratuityRequestsController::class,'alldeathgratuity']);
Route::get('/getdeathgratuityrequest/{id}',[DeathGratuityRequestsController::class,'getdeathgratuityrequest']);
Route::post('/deathgratuitysaveattachment/{id}',[DeathGratuityRequestsController::class,'deathgratuitysaveattachment']);
Route::post('/update_deathgratuity/{id}',[DeathGratuityRequestsController::class,'update_deathgratuity']);
Route::get('/getdeathgratuityAttachment/{id}',[DeathGratuityRequestsController::class,'getdeathgratuityAttachment']);
Route::get('/viewdeathgratuityAttachment/{id}',[DeathGratuityRequestsController::class,'viewdeathgratuityAttachment']);
Route::delete('/deletadeathgratuityttachment/{id}',[DeathGratuityRequestsController::class,'deletadeathgratuityttachment']);
Route::delete('/deletedeathgratuity/{id}',[DeathGratuityRequestsController::class,'deletedeathgratuity']);

// approvel

Route::get('/Death_gratuity_requests_Approvel',function(){
    return view('Death_gratuity_requests_Approvallist');
    });
Route::get('/alldeathgratuityapprovelapprovel',[DeathGratuityRequestsController::class,'alldeathgratuityapprovelapprovel']);
Route::get('/approvedeathgratuityRequest/{id}',[DeathGratuityRequestsController::class,'approvedeathgratuityRequest']);
Route::post('/rejectdeathgratuityRequest/{id}',[DeathGratuityRequestsController::class,'rejectdeathgratuityRequest']);

// advice of deduction report
Route::get('adviceofdeductionReport/{search}',[AdviceofdeductionController::class,'adviceofdeductionReport']);