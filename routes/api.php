<?php




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;


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





// Route::resource('/login', 'App\Http\Controllers\LoginController');


