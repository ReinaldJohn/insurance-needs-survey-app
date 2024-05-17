<?php

use App\Http\Controllers\InsuranceNeedsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InsuranceNeedsController::class, 'index'])->name('insurance-needs.index');
Route::post('/submit-form', [InsuranceNeedsController::class, 'submitForm'])->name('submit-form');
Route::get('/thankyou', [InsuranceNeedsController::class, 'thankYouPage'])->middleware('check.forms.completed', 'reset.forms.completed');
Route::get('/email-template', [InsuranceNeedsController::class, 'emailTemplate']);
Route::get('/generate-pdf', [InsuranceNeedsController::class, 'generatePdfReport']);

Route::get('/privacy-policy', [InsuranceNeedsController::class, 'privacyPolicy'])->name('pp-index');
Route::get('/cookie-policy', [InsuranceNeedsController::class, 'cookiePolicy'])->name('cp-index');
Route::get('/terms-and-conditions', [InsuranceNeedsController::class, 'termsAndCondition'])->name('tc-index');
Route::get('/acceptable-policy', [InsuranceNeedsController::class, 'acceptablePolicy'])->name('ap-index');
Route::get('/disclaimer', [InsuranceNeedsController::class, 'disclaimer'])->name('d-index');