<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Recuperer tous les posts
Route::get('/posts',[PostController::class,'index']);


// Recuperer un post
Route::get('/posts/show/{post}',[PostController::class,'show']);

// Inscrire un nouvel utilisateur

Route::post('/register',[UserController::class,'register']);

// Connecter un utilisateur
Route::post('/login', [UserController::class,'login']);



Route::middleware('auth:sanctum')->group(function (){
    Route::post('/posts/create',[PostController::class,'store']);
    Route::put('/posts/edit/{post}',[PostController::class,'update']);
    Route::delete('/posts/delete/{post}',[PostController::class,'destroy']);

    //Retourner l'utilisateur actuellement connecte

    Route::get('/user',function (Request $request){
        return $request->user();
    });
});
