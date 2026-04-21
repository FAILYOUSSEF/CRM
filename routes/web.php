<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use App\Http\Controllers\Client;

// Auth routes (Breeze)
require __DIR__.'/auth.php';

// Root redirect
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin())    return redirect('/admin/projects');
        if ($user->isEmployee()) return redirect('/employee/tasks');
        if ($user->isClient())   return redirect('/client/tickets');
    }
    return redirect('/login');
});

// ──────────────────────────────────────────────────────────
// ADMIN routes
// ──────────────────────────────────────────────────────────
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    // Projects
    Route::resource('projects', Admin\ProjectController::class);

    // Users
    Route::resource('users', Admin\UserController::class);

    // Tasks (admin view all)
    Route::resource('tasks', Admin\TaskController::class);

    // Tickets (admin manages replies)
    Route::get('tickets',          [Admin\TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{ticket}', [Admin\TicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets/{ticket}/reply', [Admin\TicketController::class, 'reply'])->name('tickets.reply');
    Route::delete('tickets/{ticket}',     [Admin\TicketController::class, 'destroy'])->name('tickets.destroy');

    // Reclamations (admin manages replies)
    Route::get('reclamations',                    [Admin\ReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('reclamations/{reclamation}',      [Admin\ReclamationController::class, 'show'])->name('reclamations.show');
    Route::post('reclamations/{reclamation}/reply',[Admin\ReclamationController::class, 'reply'])->name('reclamations.reply');
    Route::delete('reclamations/{reclamation}',   [Admin\ReclamationController::class, 'destroy'])->name('reclamations.destroy');

    // Categories
    Route::resource('categories', Admin\CategorieController::class);
});

// ──────────────────────────────────────────────────────────
// EMPLOYEE routes
// ──────────────────────────────────────────────────────────
Route::middleware(['auth','employee'])->prefix('employee')->name('employee.')->group(function () {

    Route::get('tasks',             [Employee\TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/{task}',      [Employee\TaskController::class, 'show'])->name('tasks.show');
    Route::patch('tasks/{task}',    [Employee\TaskController::class, 'update'])->name('tasks.update');

    Route::get('reclamations',       [Employee\ReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('reclamations/create',[Employee\ReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('reclamations',      [Employee\ReclamationController::class, 'store'])->name('reclamations.store');
    Route::get('reclamations/{reclamation}', [Employee\ReclamationController::class, 'show'])->name('reclamations.show');
});

// ──────────────────────────────────────────────────────────
// CLIENT routes
// ──────────────────────────────────────────────────────────
Route::middleware(['auth','client'])->prefix('client')->name('client.')->group(function () {

    Route::get('tickets',         [Client\TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/create',  [Client\TicketController::class, 'create'])->name('tickets.create');
    Route::post('tickets',        [Client\TicketController::class, 'store'])->name('tickets.store');
    Route::get('tickets/{ticket}',[Client\TicketController::class, 'show'])->name('tickets.show');

    Route::get('reclamations',       [Client\ReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('reclamations/create',[Client\ReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('reclamations',      [Client\ReclamationController::class, 'store'])->name('reclamations.store');
    Route::get('reclamations/{reclamation}', [Client\ReclamationController::class, 'show'])->name('reclamations.show');
});
