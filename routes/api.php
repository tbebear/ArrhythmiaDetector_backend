<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group( function() {
    Route::post('register', [PatientController::class, 'register'])->name('patient.register'); // done
    Route::post('login', [PatientController ::class, 'login'])->name('patient.login'); // done
    Route::post('doctor/login', [DoctorController::class, 'login'])->name('doctor.login');
    Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login'); // done
});

Route::middleware('auth:apipatient')->group( function() {
    Route::get('patient', [PatientController::class, 'index'])->name('patient.dashboard');
    Route::put('patient/edit', [PatientController::class, 'edit'])->name('patient.edit'); // done
    Route::put('patient/change_password', [PatientController::class, 'change_password'])->name('patient.changePassword'); // done
    Route::post('patient', [PatientController::class, 'logout'])->name('patient.logout'); // done
});

Route::middleware('auth:apidoctor')->group( function() {
    Route::get('doctor', [DoctorController::class, 'index'])->name('doctor.dashboard'); // done
    Route::put('doctor/edit', [DoctorController::class, 'edit'])->name('doctor.edit'); // done
    Route::put('doctor/change_password', [DoctorController::class, 'change_password'])->name('doctor.changePassword'); // done
    Route::post('doctor', [DoctorController::class, 'logout'])->name('doctor.logout'); // done
});

Route::middleware('auth:apiadmin')->group( function() {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard'); // done
    Route::post('admin/add_admin', [AdminController::class, 'add_admin'])->name('admin.addAdmin'); // done
    Route::put('admin/edit_admin', [AdminController::class, 'edit_admin'])->name('admin.editAdmin'); // done
    
    Route::put('admin/edit_patient/{patient_username}', [AdminController::class, 'edit_patient'])->name('admin.editPatient'); // done
    Route::delete('admin/delete_patient/{patient_username}',  [AdminController::class, 'delete_patient'])->name('admin.deletePatient'); // done

    Route::post('admin/add_doctor', [AdminController::class, 'add_doctor'])->name('admin.addDoctor'); // done
    Route::put('admin/edit_doctor/{doctor_username}', [AdminController::class, 'edit_doctor'])->name('admin.editDoctor'); // done
    Route::delete('admin/delete_doctor/{doctor_username}', [AdminController::class, 'delete_doctor'])->name('admin.delete   Doctor'); // done
    
    Route::post('admin', [AdminController::class, 'logout'])->name('admin.logout'); // done
});