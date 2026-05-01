<?php
// FILE: routes/web.php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    if (!auth()->check()) return redirect('/login');
    $user = auth()->user();
    if ($user->isAdmin())    return redirect('/admin/projects');
    if ($user->isEmployee()) return redirect('/employee/tasks');
    if ($user->isClient())   return redirect('/client/projects');
    return redirect('/dashboard');
});

// ── COMMON AUTH ROUTES ────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $projectCount = \App\Models\Project::count();
        $taskCount = \App\Models\Task::count();
        $ticketCount = \App\Models\Ticket::count();
        return view('dashboard', compact('projectCount', 'taskCount', 'ticketCount'));
    })->name('dashboard');
    
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── ADMIN ─────────────────────────────────────────────────────
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projects',   App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('users',      App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles',      App\Http\Controllers\Admin\RoleController::class);
    Route::resource('tasks',      App\Http\Controllers\Admin\TaskController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategorieController::class);

    // Tickets
    Route::get('tickets',                           [App\Http\Controllers\Admin\TicketController::class,'index'])->name('tickets.index');
    Route::get('tickets/{ticket}',                  [App\Http\Controllers\Admin\TicketController::class,'show'])->name('tickets.show');
    Route::post('tickets/{ticket}/reply',           [App\Http\Controllers\Admin\TicketController::class,'reply'])->name('tickets.reply');
    Route::delete('tickets/{ticket}',               [App\Http\Controllers\Admin\TicketController::class,'destroy'])->name('tickets.destroy');

    // Reclamations
    Route::get('reclamations',                      [App\Http\Controllers\Admin\ReclamationController::class,'index'])->name('reclamations.index');
    Route::get('reclamations/create',               [App\Http\Controllers\Admin\ReclamationController::class,'create'])->name('reclamations.create');
    Route::post('reclamations',                     [App\Http\Controllers\Admin\ReclamationController::class,'store'])->name('reclamations.store');
    Route::get('reclamations/{reclamation}',        [App\Http\Controllers\Admin\ReclamationController::class,'show'])->name('reclamations.show');
    Route::get('reclamations/{reclamation}/edit',   [App\Http\Controllers\Admin\ReclamationController::class,'edit'])->name('reclamations.edit');
    Route::put('reclamations/{reclamation}',        [App\Http\Controllers\Admin\ReclamationController::class,'update'])->name('reclamations.update');
    Route::patch('reclamations/{reclamation}',      [App\Http\Controllers\Admin\ReclamationController::class,'update']);
    Route::post('reclamations/{reclamation}/reply', [App\Http\Controllers\Admin\ReclamationController::class,'reply'])->name('reclamations.reply');
    Route::post('reclamations/{reclamation}/assign',[App\Http\Controllers\Admin\ReclamationController::class,'assign'])->name('reclamations.assign');
    Route::delete('reclamations/{reclamation}',     [App\Http\Controllers\Admin\ReclamationController::class,'destroy'])->name('reclamations.destroy');

    // Meetings
    Route::resource('meetings', App\Http\Controllers\Admin\MeetingController::class);
    Route::post('meeting-requests/{meetingRequest}/accept', [App\Http\Controllers\Admin\MeetingController::class,'acceptRequest'])->name('meeting-requests.accept');
    Route::post('meeting-requests/{meetingRequest}/refuse', [App\Http\Controllers\Admin\MeetingController::class,'refuseRequest'])->name('meeting-requests.refuse');
});

// ── EMPLOYEE ──────────────────────────────────────────────────
Route::middleware(['auth','role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::resource('projects', App\Http\Controllers\Employee\ProjectController::class)->only(['index','show']);
    Route::get('tasks',                      [App\Http\Controllers\Employee\TaskController::class,'index'])->name('tasks.index');
    Route::get('tasks/{task}',               [App\Http\Controllers\Employee\TaskController::class,'show'])->name('tasks.show');
    Route::patch('tasks/{task}',             [App\Http\Controllers\Employee\TaskController::class,'update'])->name('tasks.update');
    Route::get('reclamations',               [App\Http\Controllers\Employee\ReclamationController::class,'index'])->name('reclamations.index');
    Route::get('reclamations/create',        [App\Http\Controllers\Employee\ReclamationController::class,'create'])->name('reclamations.create');
    Route::post('reclamations',              [App\Http\Controllers\Employee\ReclamationController::class,'store'])->name('reclamations.store');
    Route::get('reclamations/{reclamation}', [App\Http\Controllers\Employee\ReclamationController::class,'show'])->name('reclamations.show');
    Route::get('meetings',                   [App\Http\Controllers\Employee\MeetingController::class,'index'])->name('meetings.index');
    Route::get('meetings/{meeting}',         [App\Http\Controllers\Employee\MeetingController::class,'show'])->name('meetings.show');
    Route::post('meetings/{meeting}/respond',[App\Http\Controllers\Employee\MeetingController::class,'respond'])->name('meetings.respond');
});

// ── CLIENT ────────────────────────────────────────────────────
Route::middleware(['auth','role:client'])->prefix('client')->name('client.')->group(function () {
    Route::resource('projects', App\Http\Controllers\Client\ProjectController::class)->only(['index','show']);
    Route::get('tickets',                    [App\Http\Controllers\Client\TicketController::class,'index'])->name('tickets.index');
    Route::get('tickets/create',             [App\Http\Controllers\Client\TicketController::class,'create'])->name('tickets.create');
    Route::post('tickets',                   [App\Http\Controllers\Client\TicketController::class,'store'])->name('tickets.store');
    Route::get('tickets/{ticket}',           [App\Http\Controllers\Client\TicketController::class,'show'])->name('tickets.show');
    Route::get('reclamations',               [App\Http\Controllers\Client\ReclamationController::class,'index'])->name('reclamations.index');
    Route::get('reclamations/create',        [App\Http\Controllers\Client\ReclamationController::class,'create'])->name('reclamations.create');
    Route::post('reclamations',              [App\Http\Controllers\Client\ReclamationController::class,'store'])->name('reclamations.store');
    Route::get('reclamations/{reclamation}', [App\Http\Controllers\Client\ReclamationController::class,'show'])->name('reclamations.show');
    Route::get('meetings',                   [App\Http\Controllers\Client\MeetingController::class,'index'])->name('meetings.index');
    Route::get('meetings/request',           [App\Http\Controllers\Client\MeetingController::class,'requestMeeting'])->name('meetings.request');
    Route::post('meetings/request',          [App\Http\Controllers\Client\MeetingController::class,'storeRequest'])->name('meetings.storeRequest');
    Route::get('meetings/{meeting}',         [App\Http\Controllers\Client\MeetingController::class,'show'])->name('meetings.show');
    Route::post('meetings/{meeting}/respond',[App\Http\Controllers\Client\MeetingController::class,'respond'])->name('meetings.respond');
});