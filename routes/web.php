<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $user = Auth::user();
    $user->tokens()->delete();

    $admin = $user->createToken('admin-token', ['create',  'update', 'soft-delete', 'delete', 'restore']);
    $author = $user->createToken('author-token', ['create', 'update', 'soft-delete']);
    $viewer = $user->createToken('view-token', ['none']);

    $tokens = $user->tokens;
    return view(
        'dashboard',
        [
            'name' => $user->name,
            'tokens' => $tokens,
            'admin' => $admin->plainTextToken,
            'author' => $author->plainTextToken,
            'viewer' => $viewer->plainTextToken,
        ]
    );
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return view('admin', ['name' => 'Mujahed']);
})->middleware('auth:sanctum');

require __DIR__ . '/auth.php';


// get all comments with button (post comments)
