<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminApprovalController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\RoleRequestController;
use App\Http\Controllers\Admin\AdminMemberTaskController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/approval-pending', function () {
    return view('admin.approvals.approval_pending');
});

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/admin/approvals', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::post('/admin/approvals/members/{user}', [AdminApprovalController::class, 'approveMember'])->name('admin.approvals.approveMembers');
    Route::post('/admin/approvals/clients/{user}', [AdminApprovalController::class, 'approveClient'])->name('admin.approvals.approveClients');
    Route::post('/admin/approvals/coordinators/{user}', [AdminApprovalController::class, 'approveCoordinator'])->name('admin.approvals.approveCoordinators');
    Route::delete('/admin/approvals/{user}', [AdminApprovalController::class, 'destroy'])->name('admin.approvals.delete');
    Route::get('/admin/new-assignments', [AdminApprovalController::class, 'getAssignmentRequests'])->name('admin.approvals.getAssignmentsRequests');
    Route::post('/admin/new-assignments/{task}', [AdminApprovalController::class, 'approveAssignment'])->name('admin.approvals.approveAssignment');
    Route::get('/admin/new-assignments/{task}', [AdminApprovalController::class, 'inviteMember'])->name('admin.approvals.inviteMember');
    Route::get('/admin/task/{id}', [AdminTaskController::class, 'showAdmin'])->name('task.show_task_details_admin');
    Route::get('/admin/{task}/invite', [AdminTaskController::class, 'invite'])->name('admin.invite');
    Route::post('/admin/{task}/invite', [AdminTaskController::class, 'sendInvitation'])->name('admin.sendInvitation');
    Route::get('/admin/role-requests', [RoleRequestController::class, 'index'])->name('admin.role-requests.index');
    Route::post('/admin/role-requests/{user}/{role}/approve',  [RoleRequestController::class, 'approve'])->name('admin.role-requests.approve');
    Route::post('/admin/role-requests/{user}/{role}/deny', [RoleRequestController::class, 'deny'])->name('admin.role-requests.deny');
    Route::get('/admin/tasks', [AdminMemberTaskController::class, 'index'])->name('admin.tasks.index');
    Route::post('/admin/tasks/{userTask}/approve', [AdminMemberTaskController::class, 'approve'])->name('admin.tasks.approve');
    Route::post('/admin/tasks/{userTask}/remove', [AdminMemberTaskController::class, 'remove'])->name('admin.tasks.remove');
    Route::get('/admin/tasks/{userTask}/details', [AdminMemberTaskController::class, 'details'])->name('admin.tasks.details');
    Route::post('/admin/tasks/{task}/finish', [AdminTaskController::class, 'finishTask'])->name('admin.finishTask');
});

Route::middleware(['auth', 'role:lid,coordinator'])->group(function () {
    Route::get('/member/open-assignments', [UserController::class, 'index'])->name('member.openAssignments.index');
    Route::post('/member/open-assignments/accept/{userTask}', [UserController::class, 'accept'])->name('member.openAssignments.accept');
    Route::post('/member/open-assignments/maybe/{userTask}', [UserController::class, 'maybe'])->name('member.openAssignments.maybe');
    Route::post('/member/open-assignments/decline/{userTask}', [UserController::class, 'decline'])->name('member.openAssignments.decline');
    Route::post('/member/become_client', [UserController::class, 'submitBecomeClient'])->name('task.submit_become_client');
    Route::get('/member/become_client', [UserController::class, 'memberBecomeClient'])->name('member.become_client');
    Route::get('/member/check_client_status', [UserController::class, 'checkClientStatus'])->name('member.check_client_status');
});
Route::middleware(['auth', 'role:opdrachtgever'])->group(function () {
    Route::post('/client/task', [ClientController::class, 'store'])->name('task.store');
    Route::get('/client/task', [ClientController::class, 'index'])->name('task.index');
    Route::get('/client/task/create', [ClientController::class, 'create'])->name('task.create');
    Route::get('/client/task/{id}', [ClientController::class, 'show'])->name('task.show');
});
