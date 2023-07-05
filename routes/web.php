<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);
Route::group(['middleware' => ['auth']], function () {
    Route::fallback(fn () => Redirect::to('/'));
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('roles', RoleController::class);
    //implement name =>''
    Route::name('user.')->prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id?}', 'edit')->name('edit');
        Route::get('/getbadges_ajax/{id?}', 'getbadges_ajax')->name('getbadges_ajax');
        Route::post('/update', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::post('/delete', 'destroy')->name('delete');
        Route::post('/force_delete', 'force_delete')->name('force_delete');
        Route::post('/upload_data', 'upload_data')->name('upload');

        Route::get('/profile/{id}', 'profile')->name('profile');
        Route::post('/restore', 'restore')->name('restore');
        Route::post('/black_list/{id}', 'black_list')->name('black_list');
        Route::get('/black_list_restore/{id}', 'black_list_restore')->name('black_list_restore');
    });

    Route::name('department.')->prefix('departments')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/edit', 'edit')->name('edit');
        Route::get('/profile/{id}', 'profile')->name('profile');
        Route::post('/delete', 'delete')->name('delete');
        Route::get('/export/{department_id}', 'export')->name('export.data');
    });
    Route::name('badge.')->prefix('badges')->controller(BadgeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/delete/{id}', 'delete')->name('delete');
    });
    Route::name('attendance.')->prefix('attendance')->controller(AttendanceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create/{id?}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/delete/{id}', 'delete')->name('delete');
        Route::post('/upload_data', 'upload_data')->name('upload');
        Route::post('/personal_attendance', 'personal_attendance')->name('personal_attendance');
    });
    Route::name('reports.')->prefix('report')->controller(ReportController::class)->group(
        function () {
            Route::get('/birthday', 'birth_day')->name('birthday');
            Route::get('/black_list_report', 'black_list_report')->name('black_list_report');
            Route::get('/attendance', 'report_view')->name('attendance');
            Route::get('/attendance_report', 'report_view_data')->name('attendance.data');
            Route::get('/absent', 'report_view_absent')->name('absent.data');
            Route::get('/absent_view', 'report_view_absent_data')->name('absent.data.view');
            Route::get('/total', 'total')->name('totals_view');
            Route::post('/totals_report', 'total_report_data')->name('totals_report');

        });
    Route::name('pdf.')->prefix('pdf')->controller(PdfController::class)->group(function () {
        Route::get('/department/{id}', 'department_data_pdf')->name('department_Export_pdf');
        Route::get('/export_blacklist', 'blacklist_pdf')->name('blacklist_export');


        Route::get('/personal_info/{code}', 'export_personal_info')->name('personal.info');
        Route::get('/attendance/{id}/{date_from?}/{date_to?}', 'attendance_pdf')->name('attendance_Export_pdf');
        Route::get('/abesnt/{id}/{date_from}/{date_to}', 'absent_pdf')->name('absent_Export_pdf');
        Route::get('/export_all', 'export_all')->name('export_all');
    });
    Route::post('/addnote', [NotesController::class, 'create'])->name('create.note');
});
