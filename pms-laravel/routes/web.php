<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('properties', PropertyController::class)->middleware(['auth', 'verified']);
Route::resource('units', UnitController::class)->middleware(['auth', 'verified']);
Route::resource('companies', CompanyController::class)->middleware(['auth', 'verified']);
Route::resource('tenants', TenantController::class)->middleware(['auth', 'verified']);

// Invoice routes
Route::resource('invoices', InvoiceController::class)->middleware(['auth', 'verified']);
Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send')->middleware(['auth', 'verified']);
Route::post('invoices/{invoice}/void', [InvoiceController::class, 'void'])->name('invoices.void')->middleware(['auth', 'verified']);
Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPDF'])->name('invoices.pdf')->middleware(['auth', 'verified']);

// Payment routes
Route::resource('payments', PaymentController::class)->middleware(['auth', 'verified']);
Route::get('payments/{payment}/allocate', [PaymentController::class, 'allocate'])->name('payments.allocate')->middleware(['auth', 'verified']);
Route::post('payments/{payment}/allocate', [PaymentController::class, 'storeAllocation'])->name('payments.store-allocation')->middleware(['auth', 'verified']);
Route::get('payments/{payment}/receipt', [PaymentController::class, 'downloadReceipt'])->name('payments.receipt')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
