<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JwtAuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    

/*---------------------------------------------User-------------------------------------------*/
Route::middleware('auth:sanctum')->get('/user/{id}', 'App\Http\Controllers\UserController@findUser');
Route::middleware('auth:sanctum')->get('/user',[UserController::class,'index']);
//Route::post('/user/add',[UserController::class,'addUser']);
Route::middleware('auth:sanctum')->post('/user/add', 'App\Http\Controllers\UserController@addUser');
Route::middleware('auth:sanctum')->put('/user/edit/{id}', 'App\Http\Controllers\UserController@updateUser');
Route::middleware('auth:sanctum')->delete('/user/delete/{id}', 'App\Http\Controllers\UserController@deleteUser');

/*---------------------------------------------Ressources------------------------------------------*/
Route::post('/ressource/add/{id}', 'App\Http\Controllers\RessourcesController@addRessource');
//Route::post('/ressource/add',[ RessourcesController::class ,'addRessource']);
Route::put("/ressource/edit/{id}", [RessourcesController::class, 'updateRessource']);
Route::delete('/ressource/delete/{id}', [RessourcesController::class ,'deleteRessource']);
Route::get('/ressource/{id}', 'App\Http\Controllers\RessourcesController@findRessource');
Route::get('/ressource', [RessourcesController::class ,'index']);
Route::post('/image', [ RessourcesController::class, 'store']);

/*--------------------------------------------Type Ressources------------------------------------------*/
Route::post('/type/add', [TypeRessourceController::class ,'addTypeRessource']);
Route::put('/type/{id}', 'App\Http\Controllers\TypeRessourceController@updateTypeRessource');
Route::delete('/type/delete/{id}', 'App\Http\Controllers\TypeRessourceController@deleteTypeRessource');
Route::get('/type/{id}', 'App\Http\Controllers\TypeRessourceController@findTypeRessource');
Route::get('/type',[TypeRessourceController::class,'index']);

/*--------------------------------------------Reservation-------------------------------------------*/
Route::post('/reservation/add/{id}/{iduser}', [ReservationController::class ,'addReservation']);
Route::put('/reservation/{id}', 'App\Http\Controllers\ReservationController@updateReservation');
Route::delete('/reservation/delete/{id}', 'App\Http\Controllers\ReservationController@deleteReservation');
Route::get('/reservation/find/{id}', 'App\Http\Controllers\ReservationController@findReservation');
Route::get('/reservation',[ReservationController::class,'index']);


//Route::get('/reservation/step-one', [ReservationController::class, 'stepOne'])->name('reservations.step.one');
//Route::get('/reservation/step-two', [ReservationController::class, 'stepTwo'])->name('reservations.step.two');

/*----------------------------------------authentification-------------------------------------------- */
Route::middleware('auth:sanctum')->get('test', [HomeController::class, 'test']);
Route::middleware('auth:sanctum')->get('/user-profile', [JwtAuthController::class, 'userProfile']);
Route::post('/register', [JwtAuthController::class, 'registeruser']);
Route::post('/login', [JwtAuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->put('/edit',[JwtAuthController::class,'update']);
Route::middleware('auth:sanctum')->get('/nom', [JwtAuthController::class, 'findByUsername']);

Route::post('/token-refresh', [JwtAuthController::class, 'refresh']);
Route::post('/signout', [JwtAuthController::class, 'signout']);
Route::get('/logout', [JwtAuthController::class, 'logout']);


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
});