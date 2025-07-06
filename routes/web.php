<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantOnboardingController;
use App\Http\Controllers\PaymentController;
use App\Models\Tenant;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Landlords
    Route::resource('landlords', LandlordController::class);
    Route::get('/landlords/export', [LandlordController::class, 'export'])->name('landlords.export');

    // Buildings
    Route::resource('buildings', BuildingController::class);
    Route::get('/buildings/export', [BuildingController::class, 'export'])->name('buildings.export');

    // Units
    Route::resource('units', UnitController::class);

    //payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/tenants/{tenant}/units', [TenantController::class, 'units'])
    ->middleware('auth')->name('tenants.units');


    Route::get('/payments/export', [PaymentController::class, 'export'])->name('payments.export');
    Route::get('/payments/export/pdf', [\App\Http\Controllers\PaymentController::class, 'exportPdf'])->name('payments.export.pdf');

    // Tenants
    Route::resource('tenants', TenantController::class);
    Route::post('/tenants/{tenant}/assign', [TenantController::class, 'assign'])->name('tenants.assign');
    Route::post('/tenants/{tenant}/unassign', [TenantController::class, 'unassign'])->name('tenants.unassign');
    Route::get('/tenants/export/all', [TenantController::class, 'exportAll'])->name('tenants.export.all');
    Route::get('/tenants/{tenant}/assign', [TenantController::class, 'assignForm'])->name('tenants.assign.form');

    // Tenant Onboarding (Multi-Step)
    Route::prefix('tenant/onboard')->name('tenant.onboard.')->group(function () {
        Route::get('/step-1', [TenantOnboardingController::class, 'step1'])->name('step1');
        Route::post('/step-1', [TenantOnboardingController::class, 'postStep1']);
        Route::get('/step-2', [TenantOnboardingController::class, 'step2'])->name('step2');
        Route::post('/step-2', [TenantOnboardingController::class, 'postStep2']);
        Route::get('/step-3', [TenantOnboardingController::class, 'step3'])->name('step3');
        Route::post('/step-3', [TenantOnboardingController::class, 'postStep3']);
        Route::get('/complete', [TenantOnboardingController::class, 'complete'])->name('complete');
    });
});

require __DIR__ . '/auth.php';
