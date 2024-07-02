<?php

use App\Helpers\ReportQueries;
use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Http\Controllers\DataReportController;
use App\Livewire\DataReport as DataReportLivewire;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffSectionController;
use App\Http\Controllers\SwitchRoleController;
use App\Http\Controllers\TemporaryUploadController;
use App\Http\Controllers\UserWithoutRoleController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\WorkLogDocumentController;
use App\Http\Controllers\WorkLogImageController;
use App\Http\Controllers\WorkScopeController;
use App\Http\Middleware\AdminIsPermitted;
use App\Models\StaffSection;
use App\Models\Submission;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Test\Example as TestExample;

Route::get('/your-role-is-empty', UserWithoutRoleController::class)->name('your-role-is-empty');

Route::middleware(['auth', 'ensure-user-has-a-role'])->group(function () {

    // Route::get('/data-report-temp', DataReportController::class)->name('data-report-temp');
    Route::get('/data-report', DataReportLivewire::class)->middleware([AdminIsPermitted::class])->name('data-report');

    // Route::get('/example', TestExample::class)->name('example');
    Route::get('/', HomeIndex::class)->name('home');
    Route::put('/switch-role/{role}', SwitchRoleController::class)->name('switch-role');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::controller(AvatarImageController::class)->group(function () {
    //     Route::post('/profile/{workLog}/images', 'store')->name('workLogs.images.store');
    //     Route::delete('/profile/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    // });

    // Route::controller(StaffSectionController::class)->middleware([AdminIsPermitted::class])->group(function() {
    //     Route::get('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja/cipta', 'create')->name('staff-sections.create');
    //     Route::post('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja', 'store')->name('staff-sections.store');
    //     Route::get('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja/{staff}', 'show')->name('staff-sections.show');
    // });

    // //     // HR uses
    // Route::controller(StaffSectionController::class)->middleware([AdminIsPermitted::class])->group(function() {
    //     Route::get('/bahagian/cipta', 'create')->name('staff-sections.create');
    //     Route::post('/bahagian', 'store')->name('staff-sections.store');
    //     Route::get('/bahagian', 'index')->name('staff-sections.index');
    //     Route::get('/bahagian/{staffSection}', 'show')->name('staff-sections.show');
    //     Route::post('/bahagian', 'store')->name('staff-sections.store');
    //     // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    // });


    // Route::controller(WorkScopeController::class)->middleware([AdminIsPermitted::class])->group(function() {
    //     Route::get('/work-scopes/create', 'create')->name('work-scopes.create');
    //     Route::get('/work-scopes', 'index')->name('work-scopes.index');
    //     Route::get('/work-scopes/{workScopes}', 'show')->name('work-scopes.show');
    //     Route::post('/work-scopes', 'store')->name('work-scopes.store');
    //     // Route::delete('/work-scopes', 'destroy')->name('work-scopes.destroy');
    // });

    // Staff | Evaluators share uses
    Route::controller(WorkLogController::class)->group(function () {
        Route::get('/logkerja/rekod-baharu', 'create')->name('worklogs.create');
        Route::get('/logkerja/{worklog}', 'show')->name('worklogs.show'); // + Edit
    });

    /* -------------------  */
    /*  Content Management  */
    /* -------------------  */

    // Actions, hidden from UI, for system
    // Want to hide only for some people
    Route::controller(WorkLogImageController::class)->group(function () {
        Route::post('/workLogs/{workLog}/images', 'store')->name('workLogs.images.store');
        Route::delete('/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    });

    Route::post('/workLogs/{workLog}/documents', [WorkLogDocumentController::class => 'store'])->name('workLogs.documents.store');
    Route::post('/workLogs/{workLog}/documents/{document}', [WorkLogDocumentController::class => 'destroy'])->name('workLogs.documents.destroy');

    /* -------------------  */
    /*  Temporary File Management  */
    /* -------------------  */
    Route::controller(TemporaryUploadController::class)->group(function () {
        Route::post('/temporary-uploads', 'process')->name('temporary-uploads.process');
        Route::delete('/temporary-uploads', 'revert')->name('temporary-uploads.revert');
        Route::get('/temporary-uploads', 'restore')->name('temporary-uploads.restore');
    });

});
