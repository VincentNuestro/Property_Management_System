<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeaseApplicationController;
use App\Http\Controllers\LeaseContractController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WorkOrderController;
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

// Inquiry routes
Route::resource('inquiries', InquiryController::class)->middleware(['auth', 'verified']);
Route::post('inquiries/{inquiry}/convert-to-reservation', [InquiryController::class, 'convertToReservation'])->name('inquiries.convert-to-reservation')->middleware(['auth', 'verified']);

// Reservation routes
Route::resource('reservations', ReservationController::class)->middleware(['auth', 'verified']);
Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm')->middleware(['auth', 'verified']);
Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel')->middleware(['auth', 'verified']);
Route::post('reservations/{reservation}/convert-to-application', [ReservationController::class, 'convertToApplication'])->name('reservations.convert-to-application')->middleware(['auth', 'verified']);
Route::get('reservations/units/property', [ReservationController::class, 'getUnits'])->name('reservations.get-units')->middleware(['auth', 'verified']);

// Lease Application routes
Route::resource('lease-applications', LeaseApplicationController::class)->middleware(['auth', 'verified']);
Route::post('lease-applications/{lease_application}/submit', [LeaseApplicationController::class, 'submit'])->name('lease-applications.submit')->middleware(['auth', 'verified']);
Route::post('lease-applications/{lease_application}/review', [LeaseApplicationController::class, 'review'])->name('lease-applications.review')->middleware(['auth', 'verified']);
Route::post('lease-applications/{lease_application}/approve', [LeaseApplicationController::class, 'approve'])->name('lease-applications.approve')->middleware(['auth', 'verified']);
Route::post('lease-applications/{lease_application}/reject', [LeaseApplicationController::class, 'reject'])->name('lease-applications.reject')->middleware(['auth', 'verified']);
Route::post('lease-applications/{lease_application}/convert-to-contract', [LeaseApplicationController::class, 'convertToContract'])->name('lease-applications.convert-to-contract')->middleware(['auth', 'verified']);

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

// Lease Contract routes
Route::resource('lease-contracts', LeaseContractController::class)->middleware(['auth', 'verified']);
Route::post('lease-contracts/{lease_contract}/activate', [LeaseContractController::class, 'activate'])->name('lease-contracts.activate')->middleware(['auth', 'verified']);
Route::post('lease-contracts/{lease_contract}/terminate', [LeaseContractController::class, 'terminate'])->name('lease-contracts.terminate')->middleware(['auth', 'verified']);
Route::post('lease-contracts/{lease_contract}/renew', [LeaseContractController::class, 'renew'])->name('lease-contracts.renew')->middleware(['auth', 'verified']);
Route::get('lease-contracts/{lease_contract}/download', [LeaseContractController::class, 'downloadContract'])->name('lease-contracts.download')->middleware(['auth', 'verified']);
Route::post('lease-contracts/{lease_contract}/add-charge', [LeaseContractController::class, 'addCharge'])->name('lease-contracts.add-charge')->middleware(['auth', 'verified']);
Route::get('lease-contracts/units/available', [LeaseContractController::class, 'getAvailableUnits'])->name('lease-contracts.get-available-units')->middleware(['auth', 'verified']);

// Maintenance Request routes
Route::resource('maintenance-requests', MaintenanceRequestController::class)->middleware(['auth', 'verified']);
Route::post('maintenance-requests/{maintenance_request}/assign', [MaintenanceRequestController::class, 'assign'])->name('maintenance-requests.assign')->middleware(['auth', 'verified']);
Route::post('maintenance-requests/{maintenance_request}/start', [MaintenanceRequestController::class, 'start'])->name('maintenance-requests.start')->middleware(['auth', 'verified']);
Route::post('maintenance-requests/{maintenance_request}/complete', [MaintenanceRequestController::class, 'complete'])->name('maintenance-requests.complete')->middleware(['auth', 'verified']);
Route::post('maintenance-requests/{maintenance_request}/cancel', [MaintenanceRequestController::class, 'cancel'])->name('maintenance-requests.cancel')->middleware(['auth', 'verified']);
Route::post('maintenance-requests/{maintenance_request}/create-work-order', [MaintenanceRequestController::class, 'createWorkOrder'])->name('maintenance-requests.create-work-order')->middleware(['auth', 'verified']);

// Work Order routes
Route::resource('work-orders', WorkOrderController::class)->middleware(['auth', 'verified']);
Route::post('work-orders/{work_order}/schedule', [WorkOrderController::class, 'schedule'])->name('work-orders.schedule')->middleware(['auth', 'verified']);
Route::post('work-orders/{work_order}/start', [WorkOrderController::class, 'start'])->name('work-orders.start')->middleware(['auth', 'verified']);
Route::post('work-orders/{work_order}/complete', [WorkOrderController::class, 'complete'])->name('work-orders.complete')->middleware(['auth', 'verified']);
Route::post('work-orders/{work_order}/cancel', [WorkOrderController::class, 'cancel'])->name('work-orders.cancel')->middleware(['auth', 'verified']);
Route::post('work-orders/{work_order}/put-on-hold', [WorkOrderController::class, 'putOnHold'])->name('work-orders.put-on-hold')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
