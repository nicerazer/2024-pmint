<?php

use App\Http\Controllers\Home;
use App\Http\Controllers\WorkLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// // })

Route::middleware('auth')->group(function () {

    Route::get('/', Home::class)->name('home');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(WorkLogController::class)->group(function () {
        Route::get('/logkerja', 'index')->name('workLogs.index');
        // Route::get('/logkerja/cipta', 'create');
        // Route::post('/logkerja', 'store');
        // Route::get('/logkerja/{worklog}', 'show')->name('worklog.show'); // + Edit
        Route::get('/logkerja/{workLog}', 'show')->name('workLogs.show'); // + Edit
        Route::put('/logkerja/{workLog}/update', 'update')->name('workLogs.update');
        // Creates revisions for every rejects, attaches comments if have any
        // Route::put('/logkerja/{workLog}/reject', 'reject');
        // Route::put('/logkerja/{workLog}/submit', 'submit');
        // Route::put('/logkerja/{workLog}/accept', 'accept');
        // Route::delete('/logkerja/buang', 'destroy');
    });

    // Route::controller(UsersController::class)->group(function () {
    //     Route::get('/users/cipta', 'create');
    //     Route::post('/users/{user}', 'show'); // + Edit
    //     Route::put('/users/{user}', 'update');

    //     Route::middleware(['must-be-admin'], function () {
    //         Route::post('/users', 'store');
    //         Route::delete('/users/buang', 'destroy');
    //     });
    // });

});


// Could be used by penilai 1, penilai 2
// Route::name('rejects.')->prefix('rejects')->controller(CommentController::class)->group(function () {
//     Route::post('/commments', 'store');
//     Route::put('/commments/{comment}', 'update');
//     Route::delete('/commments/buang', 'destroy');
// });

// // By Role
// //
// Route::name('admin.')->prefix('admin')->group(function () {
//     Route::get('/users/{user}', function (User $user) {
//     })->name('users');
// });

// Route::prefix('admin')->group(function () {
//     Route::get('/users', function () {
//         // Matches The "/admin/users" URL
//     });
// });
