<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware(['check_api_key'])->group(function () {
        Route::apiResource('/information', ApiController::class)->parameters([
            'information' => 'insuranceNeed'
        ]);

        Route::post('/information-by-phone', [ApiController::class, 'showByPhone']);
        Route::post('/generate-pdf-report', [ApiController::class, 'generatePdfReport']);
        Route::get('/get-generated-pdf/{id}', [ApiController::class, 'getGeneratedPdf']);
    });


    Route::post('/generate-api-key', [ApiController::class, 'storeApiKey'])->middleware('restrict_by_ip', 'throttle:1,1');
    // Route::post('/generate-api-key', [ApiController::class, 'storeApiKey']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
