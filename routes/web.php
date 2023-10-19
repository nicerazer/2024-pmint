<?php

use App\Http\Controllers\Home;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffSectionController;
use App\Http\Controllers\StaffUnitController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\WorkLogDocumentController;
use App\Http\Controllers\WorkLogImageController;
use App\Http\Controllers\WorkScopeController;
use App\Http\Middleware\HRIsPermitted;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Extend to the next day, dalam proses, tindakan selanjutnya sambungan => workLog baru, selesai (extend),

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

// if (! auth()->check())
//     auth()->login(User::where('email', 'test_staff@mail.com')->first());

Route::get('/that-query', function () {
    return '';
});

Route::get('/test-page', function() {
    return view('test-page');
});

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(AvatarImageController::class)->group(function () {
        Route::post('/profile/{workLog}/images', 'store')->name('workLogs.images.store');
        Route::delete('/profile/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    });

    // HR uses
    Route::controller(StaffUnitController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/staff-units/create', 'create')->name('staff-units.create');
        Route::get('/staff-units', 'index')->name('staff-units.index');
        Route::get('/staff-units/{staffUnits}', 'show')->name('staff-units.show');
        Route::post('/staff-units', 'store')->name('staff-units.store');
        // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    });

    // HR uses
    Route::controller(StaffSectionController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/work-sections/create', 'create')->name('work-sections.create');
        Route::get('/work-sections', 'index')->name('work-sections.index');
        Route::get('/work-sections/{worksections}', 'show')->name('work-sections.show');
        Route::post('/work-sections', 'store')->name('work-sections.store');
        // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    });

    Route::controller(WorkScopeController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/work-scopes/create', 'create')->name('work-scopes.create');
        Route::get('/work-scopes', 'index')->name('work-scopes.index');
        Route::get('/work-scopes/{workScopes}', 'show')->name('work-scopes.show');
        Route::post('/work-scopes', 'store')->name('work-scopes.store');
        // Route::delete('/work-scopes', 'destroy')->name('work-scopes.destroy');
    });

    Route::controller(UserController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
        Route::post('/users', 'show')->name('users.show');
        Route::get('/users/{user}')->name('users.edit');
        Route::put('/users/{user}')->name('users.update');
        Route::delete('/users/{user}')->name('users.destory');
    });

    Route::controller(WorkLogController::class)->group(function () {
        // Accessible from UI
        Route::get('/logkerja', 'index')->name('workLogs.index');
        Route::get('/logkerja/rekod-baharu', 'create')->name('workLogs.create');
        Route::get('/logkerja/{workLog}', 'show')->name('workLogs.show'); // + Edit
        // Creates revisions for every rejects, attaches comments if have any
        // Route::put('/logkerja/{workLog}/reject', 'reject');
        // Route::put('/logkerja/{workLog}/submit', 'submit');
        // Route::put('/logkerja/{workLog}/accept', 'accept');
        // Route::delete('/logkerja/buang', 'destroy');

        // Actions, hidden from UI, for system
        Route::post('/workLogs', 'store')->name('workLogs.store');
        Route::put('/workLogs/{workLog}/update', 'update')->name('workLogs.update');

    });

    // Actions, hidden from UI, for system
    // Want to hide only for some people
    Route::controller(WorkLogImageController::class)->group(function () {
        Route::post('/workLogs/{workLog}/images', 'store')->name('workLogs.images.store');
        Route::delete('/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    });

    Route::post('/workLogs/{workLog}/documents', [WorkLogDocumentController::class => 'store'])->name('workLogs.documents.store');
    Route::post('/workLogs/{workLog}/documents/{document}', [WorkLogDocumentController::class => 'destroy'])->name('workLogs.documents.destroy');

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
