<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\SpecializationsController;

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


Route::get('/', function () {
    return view('student.master');
})->name('student.home');


Route::group(['namespace' => 'Auth'] ,function() {
    Route::get('/selection', [HomeController::class, 'index'])->name('selection')->middleware('guest');
    Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout/{type}', [LoginController::class, 'logout'])->name('logout');

});


Route::group(['namespace' => 'Student'] ,function() {
    Route::get('/student/register',[RegisterController::class,'showStudentRegisterForm'])->name('student.register-view');
    Route::post('/student/register',[RegisterController::class,'createStudent'])->name('student.register');
    Route::get('/student/getSpecialization/{id}', [RegisterController::class, 'getSpecialization']);
});




Route::prefix('admin')->middleware('auth:trainer,teacher,company,admin' )->name('admin.')->group(function() {

    //home page
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

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
    Route::get('getSpecialization/{id}', [UniversityController::class, 'getSpecialization']);

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

    Route::resource('evaluations', EvaluationController::class);

});

// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('guest')->name('verification.notice');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
