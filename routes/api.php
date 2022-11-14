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


Route::get('/student', [StudentController::class, 'index']);
Route::post('/login', [LoginController::class, 'checkUser']);
Route::post('/absences', [StudentController::class, 'getAbsences']);
Route::post('/uploadImage', [StudentController::class, 'storeImage']);
Route::post('/totalAbsNbr', [StudentController::class, 'getTotalAbsNbr']);
Route::post('/totalJustAbsNbr', [StudentController::class, 'getJustifiedAbsNbr']);
Route::post('/totalNonJustAbsNbr', [StudentController::class, 'getNonJustifiedAbsNbr']);
Route::post('/totalPendJus', [StudentController::class, 'getTotalPendJus']);
Route::post('/StudentInfo', [StudentController::class, 'getStudentInfo']);
Route::post('/TeacherInfo', [TeacherController::class, 'getTeacherInfo']);
Route::post('/AdminInfo', [AdminController::class, 'getAdminInfo']);






// Route::resource('/login', 'App\Http\Controllers\LoginController');


