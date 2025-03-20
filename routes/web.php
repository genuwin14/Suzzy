<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\FacultyController;

Route::get('/faculty/register', [FacultyController::class, 'create'])->name('faculty.create');
Route::post('/faculty/store', [FacultyController::class, 'store'])->name('faculty.store');
