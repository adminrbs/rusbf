<?php

use App\Http\Controllers\CustomerController;
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
use App\Models\User;
use App\Notifications\UserNotification;



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

// Change Password 
Route::post('/change_password/{id}', [UserController::class, 'change_password']);