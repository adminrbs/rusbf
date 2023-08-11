<?php

use App\Http\Controllers\CustomerController;
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




