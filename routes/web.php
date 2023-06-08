<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApprovalController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/overview', [App\Http\Controllers\COverviewController::class, 'index'])->name('overview');

Route::get('/approval-pending', function () {
    return view('approval_pending');
});


Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/admin/approvals', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('/admin/approvals/{user}', [AdminApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::delete('/admin/approvals/{user}', [AdminApprovalController::class, 'destroy'])->name('admin.approvals.delete');
});


// Route::middleware(['auth', 'role:coordinator'])->group(function () {
//     Route::get('/admin/approvals', 'AdminApprovalController@index')->name('admin.approvals.index');
//     Route::post('/admin/approvals/{user}', 'AdminApprovalController@approve')->name('admin.approvals.approve');
// });
// Route::delete('/admin/approvals/{user}', 'AdminApprovalController@destroy')->name('admin.approvals.destroy');
