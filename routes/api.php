<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'App\Http\Controllers\RegisterController@register');
Route::post('login', 'App\Http\Controllers\RegisterController@login');


Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::get('/user', 'App\Http\Controllers\AppController@User');
    Route::get('/get_users', 'App\Http\Controllers\AppController@getUsers');
    Route::get('/get_user_details', 'App\Http\Controllers\AppController@getUserDetails');
    Route::get('/get_roles', 'App\Http\Controllers\AppController@getRoles');
    Route::get('/get_consultations', 'App\Http\Controllers\AppController@getConsultations');
    Route::get('/get_user_appointments', 'App\Http\Controllers\AppController@getUserAppointments');
    Route::get('/get_expert_appointments', 'App\Http\Controllers\AppController@getExpertAppointments');
    Route::get('/create_appointment', 'App\Http\Controllers\AppController@createAppointment');

});