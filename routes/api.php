<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\TranslationController;
    use App\Http\Controllers\AuthController;

    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });

    Route::post('/login', [AuthController::class, 'login'])->prefix('api')->middleware('api')->name('login');
    Route::group(['prefix' => 'api', 'middleware' => 'auth:sanctum'], function () {

        Route::post('/translations', [TranslationController::class, 'create']);
        Route::put('/translations/{id}', [TranslationController::class, 'update']);
        Route::get('/translations/{id}', [TranslationController::class, 'view']);
        Route::get('/translation/search', [TranslationController::class, 'search']);
        Route::get('/translations/export', [TranslationController::class, 'export']);
    });

