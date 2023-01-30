<?php


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
use App\Http\Controllers\SpecializationsController;
use App\Http\Controllers\WebSite\websiteController;

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


// Route::get('/', function () {
//     return view('student.master');
// })->name('student.home');

// login to control panle
Route::group(['namespace' => 'Auth'] ,function() {
    Route::get('/selection-guard', [HomeController::class, 'index'])->name('selection')->middleware('guest');
    Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout/{type}', [LoginController::class, 'logout'])->name('logout');

});

// student register
Route::group(['namespace' => 'Student'] ,function() {
    Route::get('/student/register',[RegisterController::class,'showStudentRegisterForm'])->name('student.register-view');
    Route::post('/student/register',[RegisterController::class,'createStudent'])->name('student.register');
    Route::get('/student/get/specialization/{id}', [RegisterController::class, 'get_specialization']);
});


// route of website
Route::prefix('/')->name('student.')->group(function(){
    // home page
    Route::get('/',[websiteController::class,'index'])->name('home');

    // company page
    Route::get('student/company',[websiteController::class,'showCompany'])->name('company');


});



// routes of control panel
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

    // evaluations
    Route::resource('evaluations', EvaluationController::class);
    Route::post('apply_evaluation/{id}', [EvaluationController::class, 'apply_evaluation'])->name('apply_evaluation');

    //settings
    Route::get('settings', [HomeController::class, 'settings'])->name('settings');
    Route::post('settings', [HomeController::class, 'settings_store'])->name('settings_store');


});

// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('guest')->name('verification.notice');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
