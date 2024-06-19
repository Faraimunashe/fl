<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', 'App\Http\Controllers\admin\DashboardController@index')->name('admin-dashboard');
    Route::post('/admin/update-application', 'App\Http\Controllers\admin\DashboardController@update')->name('admin-update-application');

    Route::get('/admin/periods', 'App\Http\Controllers\admin\PeriodController@index')->name('admin-periods');
    Route::post('/admin/add-period', 'App\Http\Controllers\admin\PeriodController@add')->name('admin-add-period');
    Route::post('/admin/update-period', 'App\Http\Controllers\admin\PeriodController@update')->name('admin-update-period');

    Route::get('/admin/permits', 'App\Http\Controllers\admin\PermitsController@index')->name('admin-permits');
    Route::post('/admin/search-permit', 'App\Http\Controllers\admin\PermitsController@index')->name('admin-search-permit');
    Route::post('/admin/update-permit', 'App\Http\Controllers\admin\PermitsController@update')->name('admin-update-permit');

    Route::get('/admin/complaints', 'App\Http\Controllers\admin\ComplaintController@index')->name('admin-complaints');

    Route::get('/admin/tasks', 'App\Http\Controllers\admin\TaskController@index')->name('admin-tasks');
    Route::post('/admin/add-task', 'App\Http\Controllers\admin\TaskController@add')->name('admin-add-task');

});

Route::group(['middleware' => ['auth', 'role:user']], function(){
    Route::get('/user/dashboard', 'App\Http\Controllers\user\DashboardController@index')->name('user-dashboard');
    Route::post('/user/upload-image', 'App\Http\Controllers\user\DashboardController@upload')->name('user-upload-image');
    Route::get('/user/download-permit', 'App\Http\Controllers\user\DashboardController@generatePDF')->name('user-download-permit');
    Route::get('/user/download-img', 'App\Http\Controllers\user\DashboardController@generateIMG')->name('user-download-img');

    Route::get('/user/application', 'App\Http\Controllers\user\ApplicationController@index')->name('user-application');
    Route::post('/user/apply', 'App\Http\Controllers\user\ApplicationController@apply')->name('user-apply');
    Route::get('/user/extend-permit', 'App\Http\Controllers\user\ApplicationController@extend_index')->name('user-extend-permit');
    Route::post('/user/extend-permit', 'App\Http\Controllers\user\ApplicationController@extend')->name('user-extend-permit');

    Route::get('/user/complaints', 'App\Http\Controllers\user\ComplaintController@index')->name('user-complaints');
    Route::post('/user/add-complaint', 'App\Http\Controllers\user\ComplaintController@add')->name('user-add-complaint');
});

Route::group(['middleware' => ['auth', 'role:officer']], function(){
    Route::get('/officer/dashboard', 'App\Http\Controllers\officer\DashboardController@index')->name('officer-dashboard');
    Route::post('/officer/update-task', 'App\Http\Controllers\officer\DashboardController@update')->name('officer-update-task');

});

require __DIR__.'/auth.php';
