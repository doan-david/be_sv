<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AdminController;
use Modules\Admin\App\Http\Controllers\ClassController;
use Modules\Admin\App\Http\Controllers\RoleController;
use Modules\Admin\App\Http\Controllers\StudentController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//    Route::get('admin', fn (Request $request) => $request->user())->name('admin');

});
Route::prefix('admins')->group(function () {
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/store', [RoleController::class, 'store']);
        Route::get('/{id}/show', [RoleController::class, 'show']);
        Route::put('/{id}/update', [RoleController::class, 'update']);
        Route::delete('/{id}/delete', [RoleController::class, 'destroy']);
    });

    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/store', [AdminController::class, 'store']);
        Route::get('/{id}/show', [AdminController::class, 'show']);
        Route::put('/{id}/update', [AdminController::class, 'update']);
        Route::delete('/{id}/delete', [AdminController::class, 'destroy']);
    });

    Route::prefix('classes')->group(function () {
        Route::get('/', [ClassController::class, 'index']);
        Route::get('/get-class-list', [ClassController::class, 'getClassList']);
        Route::get('/{id}/show', [ClassController::class, 'show']);
        Route::get('/search', [ClassController::class, 'search']);
        Route::get('/{code}/has-by-code', [ClassController::class, 'hasByCode']);
        Route::get('/{name}/has-by-name', [ClassController::class, 'hasByName']);
        Route::get('/get-list-sort-order', [ClassController::class, 'getListSortOrder']);
        Route::get('/show-class-list-by-code', [ClassController::class, 'showClassListByCode']);
        Route::get('/{id}/student/show-student-list', [ClassController::class, 'showStudentList']);
        Route::get('/has-student-list', [ClassController::class, 'hasStudentList']);

        Route::post('/store', [ClassController::class, 'store']);
        Route::patch('/{id}/update', [ClassController::class, 'update']);
        Route::patch('/{id}/update-status', [ClassController::class, 'updateStatus']);
        Route::delete('/{id}/delete', [ClassController::class, 'destroy']);
        Route::post('/delete-multiple', [ClassController::class, 'deleteMultiple']);
        Route::post('/{id}/record', [ClassController::class, 'record']);
        Route::post('/record-multiple', [ClassController::class, 'recordMultiple']);
        Route::post('/import-excel-data', [ClassController::class, 'importExcelData']);

        Route::get('/export-csv', [ClassController::class, 'exportCsv']);
        Route::get('/export-xlsx', [ClassController::class, 'exportXlsx']);

        Route::get('/recycle', [ClassController::class, 'recycle']);
        Route::get('{id}/show-recycled', [ClassController::class, 'showRecycled']);
        Route::post('/{id}/restore', [ClassController::class, 'restore']);
        Route::post('/restore-multiple', [ClassController::class, 'restoreMultiple']);
        Route::post('/restore-all', [ClassController::class, 'restoreAll']);
        Route::delete('{id}/force-delete', [ClassController::class, 'forceDelete']);
        Route::delete('force-delete-multiple', [ClassController::class, 'forceDeleteMultiple']);
        Route::delete('force-delete-all', [ClassController::class, 'forceDeleteAll']);
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/store', [StudentController::class, 'store']);
        Route::get('/{id}/show', [StudentController::class, 'show']);
        Route::post('/show-student-list', [StudentController::class, 'showStudentList']);
        Route::get('/search', [StudentController::class, 'search']);
        Route::get('/{code}/has-by-code', [StudentController::class, 'hasByCode']);
        Route::get('/{email}/has-by-email', [StudentController::class, 'hasByEmail']);
        Route::get('/{phone}/has-by-phone', [StudentController::class, 'hasByPhone']);

        Route::patch('/{id}/update', [StudentController::class, 'update']);
        Route::patch('/{id}/update-status', [StudentController::class, 'updateStatus']);
        Route::delete('/{id}/delete', [StudentController::class, 'destroy']);
        Route::delete('/delete-multiple', [StudentController::class, 'deleteMultiple']);
        Route::post('/{id}/record', [StudentController::class, 'record']);
        Route::post('/record-multiple', [StudentController::class, 'recordMultiple']);
        Route::post('/import-excel-data', [StudentController::class, 'importExcelData']);
        Route::get('/export-csv', [StudentController::class, 'exportCsv']);
        Route::get('/export-xlsx', [StudentController::class, 'exportXlsx']);

        Route::get('/recycle', [StudentController::class, 'recycle']);
    });
});

