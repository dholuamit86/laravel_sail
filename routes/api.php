<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::post('/login', function (Request $request){
    //$credentials = ['email'=>$request->username, 'password'=>$request->password];
    $credentials = ['email'=>$request->input('username'), 'password'=>$request->input('password')];
    $attempt = Auth::attempt($credentials);
    if($attempt){
        $user = Auth::user();
        $token = $user->createToken('Laravel-sanctum-Token')->plainTextToken;        
        return response()->json(['status'=>'success', 'user'=>$user, 'token'=>$token]);
    } else {
        return response()->json(['status'=>'failed', 'message'=>'Username or password is incorrect!']);
    }
});

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::get('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status'=>'success', 'message'=>'User logged out!']);
    });
    Route::get('/profile-new', function (Request $request) {
        return response()->json(['status'=>'success', 'user'=>$request->user()]);
    });
    Route::get('/profile', function (Request $request) {
        if(Auth::check()){
            return response()->json(['status'=>'success', 'user'=>Auth::user()]);
        } else {
            return response()->json(['status'=>'failed', 'message'=>'Please login to access']);
            //return $request;
            //return 'Non-logged in user';
        }
    });
});

/*
Route::get('/logout', function (Request $request) {
    return $request->user()->token()->revoke();
})->middleware('auth:api');

Route::get('/profile', function (Request $request) {
    //return $request->user();
    if(Auth::check()){
        return Auth::user();
    } else {
        return $request;
        return 'Non-logged in user';
    }
})->middleware('auth:api');
*/