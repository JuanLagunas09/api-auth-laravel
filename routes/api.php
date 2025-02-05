<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\AuthController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::post('auth/register', [AuthController::class, 'Register']);
Route::post('auth/login', [AuthController::class, 'Login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('departaments', DepartamentController::class);
    Route::get('employeesall', [EmployeeController::class, 'all']);
    Route::get('employeesbydepartament', [EmployeeController::class, 'employeesByDepartament']);
    Route::get('auth/logout', [AuthController::class, 'Logout']);
});
