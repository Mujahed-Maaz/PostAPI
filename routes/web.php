<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/token-test', function () {
    $user = auth('sanctum')->user();
    $adminToken = $user->createToken('admin-token', ['create',  'update', 'soft-delete', 'delete', 'restore']);
    $authorToken = $user->createToken('author-token', ['create', 'update', 'soft-delete']);
    $viewToken = $user->createToken('view-token', ['none']);
    return [
        'admin' => $adminToken->plainTextToken,
        'author' => $authorToken->plainTextToken,
        'view' => $viewToken->plainTextToken
    ];
})->middleware('auth:sanctum');

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth:sanctum');

require __DIR__ . '/auth.php';


// get all comments with button (post comments)
