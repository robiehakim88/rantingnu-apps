<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\OrphanController;
use App\Http\Controllers\BudgetController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Grup middleware untuk rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk surat
    Route::get('/letters', [LetterController::class, 'index'])->name('letters.index');
    Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/letters/{letter}/edit', [LetterController::class, 'edit'])->name('letters.edit');
    Route::put('/letters/{letter}', [LetterController::class, 'update'])->name('letters.update');
    Route::delete('/letters/{letter}', [LetterController::class, 'destroy'])->name('letters.destroy');
    Route::delete('/letters/{letter}/delete_file/{filePath}', [LetterController::class, 'deleteFile'])
    ->name('letters.delete_file');

    // Rute untuk anggota
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');

    // Rute untuk keuangan
    Route::get('/finances', [FinanceController::class, 'index'])->name('finances.index');
    Route::get('/finances/create', [FinanceController::class, 'create'])->name('finances.create');
    Route::post('/finances', [FinanceController::class, 'store'])->name('finances.store');
    Route::get('/finances/{finance}/edit', [FinanceController::class, 'edit'])->name('finances.edit');
    Route::put('/finances/{finance}', [FinanceController::class, 'update'])->name('finances.update');
    Route::delete('/finances/{finance}', [FinanceController::class, 'destroy'])->name('finances.destroy');

    // Rute untuk kegiatan
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    
    //Route::resource('events', EventController::class);
    //Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    
    Route::delete('/events/{event}/delete_photo/{photo}', [EventController::class, 'deletePhoto'])
    ->name('events.delete_photo');

    // Rute untuk peran
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
    Route::get('/places/create', [PlaceController::class, 'create'])->name('places.create');
    Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');
    
    
    
    Route::get('/finances/report/income-expense', [FinanceController::class, 'reportIncomeExpense'])
    ->name('finances.report.income-expense');
    Route::get('/finances/report/income-expense/pdf', [FinanceController::class, 'downloadIncomeExpensePdf'])
    ->name('finances.report.income-expense.pdf');
    Route::get('/finances/report/cash-flow', [FinanceController::class, 'reportCashFlow'])
    ->name('finances.report.cash-flow');
    
    Route::get('/orphans', [OrphanController::class, 'index'])->name('orphans.index');
    Route::get('/orphans/create', [OrphanController::class, 'create'])->name('orphans.create');
    Route::post('/orphans', [OrphanController::class, 'store'])->name('orphans.store');
    Route::get('/orphans/{orphan}/edit', [OrphanController::class, 'edit'])->name('orphans.edit');
    Route::put('/orphans/{orphan}', [OrphanController::class, 'update'])->name('orphans.update');
    Route::delete('/orphans/{orphan}', [OrphanController::class, 'destroy'])->name('orphans.destroy');

    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
    Route::get('/budgets/export_pdf', [BudgetController::class, 'exportPdf'])->name('budgets.export_pdf');

    
    

});

require __DIR__.'/auth.php';