<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\TranslationController;
    use App\Http\Controllers\AuthController;

    Route::get('/', function () {
        return view('welcome');
    });
    require_once __DIR__ . '/api.php';

