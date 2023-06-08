<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::get('/approval-pending', function () {
    return view('approval_pending');
});

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/admin/approvals', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('/admin/approvals/{user}', [AdminApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::delete('/admin/approvals/{user}', [AdminApprovalController::class, 'destroy'])->name('admin.approvals.delete');
    Route::get('/admin/new-assignments', [AdminApprovalController::class, 'getAssignmentRequests'])->name('admin.approvals.getAssignmentsRequests');
    Route::post('/admin/new-assignments/{task}', [AdminApprovalController::class, 'approveAssignment'])->name('admin.approvals.approveAssignment');
    Route::get('/admin/new-assignments/{task}', [AdminApprovalController::class, 'inviteMember'])->name('admin.approvals.inviteMember');
});

Route::middleware(['auth', 'role:lid'])->group(function () {
    Route::get('/member/open-assignments', [UserController::class, 'index'])->name('member.openAssignments.index');
    Route::post('/member/open-assignments/accept/{userTask}', [UserController::class, 'accept'])->name('member.openAssignments.accept');
    Route::post('/member/open-assignments/maybe/{userTask}', [UserController::class, 'maybe'])->name('member.openAssignments.maybe');
    Route::post('/member/open-assignments/decline/{userTask}', [UserController::class, 'decline'])->name('member.openAssignments.decline');
});

// Route::get('task',function(){
// return view('opdracht.task');
// });
Route::post('task', [TaskController::class, 'store'])->name('task.store');
Route::get('task', [TaskController::class, 'index'])->name('task.index');
Route::get('task/create', [TaskController::class, 'create'])->name('task.create');
Route::post('/task/become_client', [TaskController::class, 'submitBecomeClient'])->name('task.submit_become_client');
Route::get('/task/{id}', [TaskController::class, 'show'])->name('task.show');
Route::get('/task/{id}', [TaskController::class, 'showAdmin'])->name('task.show_task_details_admin');

