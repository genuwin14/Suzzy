<?php

// web.php

use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfNotAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', [AdminController::class, 'welcome'])->name('admin.welcome');
Route::get('/redirect', [AdminController::class, 'loader'])->name('admin.loader');
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate'); // Change here
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin', RedirectIfNotAdmin::class, PreventBackHistory::class])->group(function () {
    // Main Routes
    Route::get('/admin/app', [AdminController::class, 'app'])->name('admin.app');

    // Register Routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/key-register', [AdminController::class, 'create'])->name('admin.create');

    //Faculty Routes
    Route::get('/admin/faculty/register', [AdminController::class, 'createFaculty'])->name('admin.createFaculty');
    Route::patch('/admin/faculty/{faculty_id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::post('/admin/faculty/store', [AdminController::class, 'store'])->name('admin.store');
    
    // Lab Key Routes
    Route::get('/admin/labkeys', [AdminController::class, 'labKeys'])->name('admin.labkeys');
    Route::post('/admin/labkeys/store', [AdminController::class, 'storeLabKey'])->name('admin.labkeys.store');

    Route::get('/admin/list', [AdminController::class, 'list'])->name('admin.list');
    Route::get('/admin/log', [AdminController::class, 'log'])->name('admin.log');
});

// use App\Http\Controllers\Api\LogsApiController;

// Route::post('/logs/store', [LogsApiController::class, 'store'])
//     ->name('logs.store')
//     ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// use App\Http\Controllers\Api\FacultyControllerAPI;

// Route::get('api/faculty', [FacultyControllerAPI::class, 'index']);
// Route::get('api/faculty/{id}', [FacultyControllerAPI::class, 'show']);

// use App\Http\Controllers\Api\LabKeyControllerApi;

// Route::get('api/key', [LabKeyControllerApi::class, 'index']);
// Route::get('api/key/{id}', [LabKeyControllerApi::class, 'show']);

use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\Api\LogsApiController;
use App\Http\Controllers\Api\FacultyControllerAPI;
use App\Http\Controllers\Api\LabKeyControllerApi;

// With API Key
Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('api/logs', [LogsApiController::class, 'index']);
    Route::post('/logs/borrowed', [LogsApiController::class, 'storeBorrowed'])
        ->name('logs.storeBorrowed')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/logs/returned', [LogsApiController::class, 'storeReturned'])
        ->name('logs.storeReturned')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::get('api/faculty', [FacultyControllerAPI::class, 'index']);
    Route::get('api/faculty/{id}', [FacultyControllerAPI::class, 'show']);
    Route::post('/faculty/store', [FacultyControllerAPI::class, 'store'])
        ->name('faculty.store')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::get('api/key', [LabKeyControllerApi::class, 'index']);
    Route::get('api/key/{id}', [LabKeyControllerApi::class, 'show']);
    Route::post('/key/store', [LabKeyControllerApi::class, 'store'])
        ->name('key.store')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
});

// Without API Key
// Route::post('/logs/store', [LogsApiController::class, 'store'])
//     ->name('logs.store')
//     ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route::get('api/faculty', [FacultyControllerAPI::class, 'index']);
// Route::get('api/faculty/{id}', [FacultyControllerAPI::class, 'show']);
// Route::post('/faculty/store', [FacultyControllerAPI::class, 'store'])
//     ->name('faculty.store')
//     ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route::get('api/key', [LabKeyControllerApi::class, 'index']);
// Route::get('api/key/{id}', [LabKeyControllerApi::class, 'show']);
