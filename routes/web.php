<?php

use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\User;
use App\Models\SupervisionRequest;
use App\Models\StudentSession;

Route::get('/', function () {

    if(Auth::id()) {
        $role = Auth::user()->role;

        return redirect('home');

    } else {
        return redirect('/login');
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/home',[AdminController::class,'index'])->name('home');

    // Admin Routes Group
    Route::group(['middleware' => \App\Http\Middleware\Admin::class], function () {
        // User Management
        Route::get('/create_student', [AdminController::class, 'create_student']);
        Route::post('/create_student', [AdminController::class, 'store_student'])->name('admin.store_student');
        Route::get('/create_lecturer', [AdminController::class, 'create_lecturer']);
        Route::post('/create_lecturer', [AdminController::class, 'store_lecturer'])->name('admin.store_lecturer');
        Route::get('/create_admin', [AdminController::class, 'create_admin']);
        Route::post('/create_admin', [AdminController::class, 'store_admin'])->name('admin.store_admin');

        Route::get('/search_users', [AdminController::class, 'search_users']);
        Route::get('/view_admins', [AdminController::class, 'view_admins']);
        Route::get('/view_lecturers', [AdminController::class, 'view_lecturers']);
        Route::get('/view_students', [AdminController::class, 'view_students']);
        Route::get('/edit_user/{id}', [AdminController::class, 'edit_user']);
        Route::post('/update_user/{id}', [AdminController::class, 'update_user']);
        Route::get('/delete_user/{id}', [AdminController::class, 'delete_user']);

        // Session Management
        Route::get('/student_session', [AdminController::class, 'student_session']);
        Route::post('/store_session', [AdminController::class, 'store_session']);
        Route::get('/search_session', [AdminController::class,'search_session']);
        Route::get('/delete_session/{id}', [AdminController::class, 'delete_session']);
        Route::get('/edit_session/{id}', [AdminController::class, 'edit_session']);
        Route::post('/update_session/{id}', [AdminController::class, 'update_session']);

        // Profile Management
        Route::get('/admin_edit_student_profile/{id}', [AdminController::class, 'admin_edit_student_profile']);
        Route::post('/admin_update_student_profile/{id}', [AdminController::class, 'admin_update_student_profile']);
        Route::get('/admin_edit_lecturer_profile/{id}', [AdminController::class, 'admin_edit_lecturer_profile']);
        Route::post('/admin_update_lecturer_profile/{id}', [AdminController::class, 'admin_update_lecturer_profile']);

        // Request Management
        Route::get('/manage_request', [AdminController::class, 'manage_request']);
        Route::get('/search_request', [AdminController::class, 'search_request']);
        Route::get('/update_student_request/{id}', [AdminController::class, 'update_student_request']);
        Route::post('/updated_student_request/{id}', [AdminController::class, 'updated_student_request']);
        Route::get('/delete_request/{id}', [AdminController::class, 'delete_request']);

        // Supervision Management
        Route::get('/create_supervision', [AdminController::class, 'create_supervision']);
        Route::post('/create_student_request', [AdminController::class, 'create_student_request']);
        Route::get('/select_request_supervisor', [AdminController::class, 'select_request_supervisor']);
        Route::get('/select_request_student', [AdminController::class, 'select_request_student']);
        Route::get('/search_supervisor_inRequest', [AdminController::class, 'search_supervisor_inRequest']);
        Route::get('/search_student_inRequest', [AdminController::class, 'search_student_inRequest']);
        Route::get('/change_request_supervisor/{id}', [AdminController::class, 'change_request_supervisor']);
        Route::get('/search_supervisor/{id}', [AdminController::class,'search_supervisor']);
        Route::get('/update_requested_supervisor/{request_id}/{supervisor_id}', [AdminController::class, 'update_requested_supervisor']);

        // Expertise Management
        Route::get('/manage_expertise', [AdminController::class, 'manage_expertise']);
        Route::post('/add_expertise', [AdminController::class, 'add_expertise']);
        Route::get('/delete_expertise/{id}', [AdminController::class, 'delete_expertise']);
        Route::get('/search_expertise', [AdminController::class, 'search_expertise']);
    });

    Route::group(['middleware' => \App\Http\Middleware\Supervisor::class], function () {
        Route::get('/profile', [SupervisorController::class, 'view_profile']);
        Route::post('/create_profile/{id}', [SupervisorController::class, 'create_profile']);
        Route::get('/edit_profile/{id}', [SupervisorController::class, 'edit_profile']);
        Route::post('/update_profile/{id}', [SupervisorController::class, 'update_profile']);

        Route::get('/view_request/{id}', [SupervisorController::class, 'view_request']);
        Route::get('/view_supervisee/{id}', [SupervisorController::class, 'view_supervisee']);
        Route::get('/view_supervisee_profile/{id}', [SupervisorController::class, 'view_supervisee_profile']);
        Route::get('/approve_request/{id}', [SupervisorController::class, 'approve_request']);
        Route::get('/decline_request/{id}', [SupervisorController::class, 'decline_request']);

        Route::get('/supervisee-report/{lecturerId}', [SupervisorController::class, 'generateSuperviseeReport'])->name('supervisee.report');
        Route::get('/student-report/{studentId}', [SupervisorController::class, 'generateStudentReport'])->name('student.report');
    });

    Route::group(['middleware' => \App\Http\Middleware\Student::class], function () {
        Route::get('/find_supervisor', [StudentController::class, 'find_supervisor']);
        Route::get('/search_supervisor', [StudentController::class, 'search_supervisor']);

        Route::get('/student_profile', [StudentController::class, 'view_profile']);
        Route::post('/student_create_profile/{id}', [StudentController::class, 'create_profile']);
        Route::get('/student_edit_profile/{id}', [StudentController::class, 'edit_profile']);
        Route::post('/student_update_profile/{id}', [StudentController::class, 'update_profile']);

        Route::get('/view_lecturer/{id}', [StudentController::class, 'view_lecturer']);
        Route::get('/request_page/{id}', [StudentController::class, 'request_page']);
        Route::post('/request_supervision/{id}', [StudentController::class, 'request_supervision']);
        Route::get('/view_supervision_request', [StudentController::class, 'view_supervision_request']);
        Route::get('/edit_supervision_request/{id}',[StudentController::class, 'edit_supervision_request']);
        Route::get('/update_supervision_request/{id}',[StudentController::class, 'update_supervision_request']);
        Route::get('/delete_supervision_request/{id}', [StudentController::class, 'delete_supervision_request']);

        Route::get('/propose_title', [StudentController::class, 'propose_title']);
        Route::get('/recommend_supervisors', [StudentController::class, 'recommend_supervisors']);

        Route::get('/view_my_supervisor/{id}', [StudentController::class, 'view_my_supervisor']);
    });

});
