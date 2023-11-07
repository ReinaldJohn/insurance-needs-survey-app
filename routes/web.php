<?php

use App\Http\Controllers\InsuranceNeedsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InsuranceNeedsController::class, 'index'])->name('insurance-needs.index');
Route::post('/submit-form', [InsuranceNeedsController::class, 'submitForm'])->name('submit-form');
Route::get('/thankyou', [InsuranceNeedsController::class, 'thankYouPage'])->middleware('check.forms.completed', 'reset.forms.completed');
Route::get('/email-template', [InsuranceNeedsController::class, 'emailTemplate']);
Route::get('/generate-pdf', [InsuranceNeedsController::class, 'generatePdfReport']);