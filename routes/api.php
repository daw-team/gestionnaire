<?php




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/logout', [LoginController::class, 'logout']);


Route::post('/login', [LoginController::class, 'checkUser']);
//Student Functions
Route::get('/student', [StudentController::class, 'index']);

Route::post('/totalAbsNbr', [StudentController::class, 'getTotalAbsNbr']);
Route::post('/AllAbsences', [StudentController::class, 'getAllAbsences']);


Route::post('/nonJusAbsences', [StudentController::class, 'getNonJusAbsences']);
Route::post('/totalNonJustAbsNbr', [StudentController::class, 'getNonJustifiedAbsNbr']);

Route::post('/JustAbs', [StudentController::class, 'getJusAbsences']);
Route::post('/totalJustAbsNbr', [StudentController::class, 'getJustifiedAbsNbr']);


Route::post('/totalPendJus', [StudentController::class, 'getTotalPendJusNbr']);
Route::post('/PendJus', [StudentController::class, 'getPenAbsences']);


Route::post('/uploadImage', [StudentController::class, 'storeImage']);
Route::post('/StudentInfo', [StudentController::class, 'getStudentInfo']);
Route::post('/changeStudentInfo', [StudentController::class, 'changeStudentInfo']);
Route::get('/AllModules', [StudentController::class, 'getAllModules']);
Route::get('/sendTeacherEmail', [StudentController::class, 'sendTeacherEmail']);




//Teacher Functions
Route::post('/TeacherInfo', [TeacherController::class, 'getTeacherInfo']);
Route::post('/ChangeTeacherInfo', [TeacherController::class, 'changeTeacherInfo']);

//Get the list of all students
Route::get('/AllStudents', [TeacherController::class, 'getAllStudents']);



//Admin Functions
Route::post('/AdminInfo', [AdminController::class, 'getAdminInfo']);
Route::post('/ChangeAdminInfo', [AdminController::class, 'changeAdminInfo']);






// Route::resource('/login', 'App\Http\Controllers\LoginController');


