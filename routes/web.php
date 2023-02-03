<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SpecializationsController;
use App\Http\Controllers\WebSite\websiteController;
use App\Models\Company;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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



// login to control panle
Route::group(['namespace' => 'Auth'] ,function() {
    Route::get('/selection-type', [HomeController::class, 'index'])->name('selection')->middleware('guest');
    Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout/{type}', [LoginController::class, 'logout'])->name('logout');
});

// student register
Route::group(['namespace' => 'Student'] ,function() {
    Route::get('/student/register',[RegisterController::class,'showStudentRegisterForm'])->name('student.register-view');
    Route::post('/student/register',[RegisterController::class,'createStudent'])->name('student.register');
    Route::get('/student/get/specialization/{id}', [RegisterController::class, 'get_specialization']);

    // verify email
    Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('student.verify');
});


// login to website
Route::group(['namespace' => 'AuthStudent'] ,function() {
    Route::get('/students', [LoginController::class, 'loginForm_student'])->middleware('guest')->name('student.login.show');
    Route::post('/login/student', [LoginController::class, 'login_studens'])->name('login_studens');

});
// update Password
Route::group(['namespace' => 'updatePassword'] ,function() {
        //password
        Route::get('edit/password/{type}', [HomeController::class , 'editPassword'])->name('edit-password')->middleware('auth:student,trainer,teacher,company,admin');
        Route::post('update/password', [HomeController::class , 'updatePassword'])->name('update-password')->middleware('auth:student,trainer,teacher,company,admin');
});

// reset Password
Route::group(['namespace' => 'resetPassword'] ,function() {
    Route::get('forget-password/{type}', [ResetPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get')->middleware('guest');
Route::post('forget-password', [ResetPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post')->middleware('guest');
Route::get('reset-password/{type}/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get')->middleware('guest');
Route::post('reset-password', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post')->middleware('guest');
});




// route of website
Route::prefix('/')->middleware('auth:student','is_verify_email')->name('student.')->group(function(){
    // home page
    Route::get('/',[websiteController::class,'index'])->name('home');

    // company page
    Route::get('student/company',[websiteController::class,'showCompany'])->name('company');

    //profile
    Route::get('/profile/{slug}',[websiteController::class,'profile'])->name('profile');
    Route::put('/profile/{slug}', [websiteController::class, 'editProfile'])->name('profile_edit');



});



// routes of control panel
Route::prefix('admin')->middleware('auth:admin,teacher,trainer,company')->name('admin.')->group(function() {

    //home page
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    //profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [HomeController::class, 'profile_edit'])->name('profile_edit');

    // Category
    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forcedelete'])->name('categories.forcedelete');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::resource('categories', CategoryController::class);

    // Company
    Route::get('companies/trash', [CompanyController::class, 'trash'])->name('companies.trash');
    Route::delete('companies/{company}/forcedelete', [CompanyController::class, 'forceDelete'])->name('companies.forcedelete');
    Route::post('companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    Route::resource('companies', CompanyController::class);

    //university
    Route::resource('universities',UniversityController::class);
    Route::get('get/specialization/{id}', [UniversityController::class, 'get_specialization']);

    // specialization
    Route::resource('specializations', SpecializationsController::class);

    // trainer
    Route::resource('trainers', TrainerController::class);

    // teacher
    Route::resource('teachers', TeacherController::class);

    // admin
    Route::resource('admins', AdminController::class);

    //student
    Route::get('students/trash', [StudentController::class, 'trash'])->name('students.trash');
    Route::delete('students/{id}/forcedelete', [StudentController::class, 'forceDelete'])->name('students.forcedelete');
    Route::post('students/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
    Route::resource('students', StudentController::class);
    // show evaluation
    Route::get('show/evaluation/{id}', [StudentController::class, 'show_evaluation'])->name('show_evaluation');
    // export evaluation as pdf
    Route::get('export/pdf/{id}', [StudentController::class, 'export_pdf'])->name('export_pdf');

    // evaluations
    Route::resource('evaluations', EvaluationController::class);
    Route::post('apply_evaluation/{id}', [EvaluationController::class, 'apply_evaluation'])->name('apply_evaluation');

    //settings
    Route::get('settings', [HomeController::class, 'settings'])->name('settings');
    Route::post('settings', [HomeController::class, 'settings_store'])->name('settings_store');


});






