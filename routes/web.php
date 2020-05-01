<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isadmin;
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
//     return view('welcome');
// });
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
// Route::get('/user', ['middleware' => 'isadmin',function(){
//     return view('user');
// }]);
// Route::get('/admin',['middleware' => 'isadmin', function(){
//     return view('admin');
// }]);
Route::group(['middleware' => ['isadmin']], function () {
    Route::get('/admin', function(){
        return view('admin');
    });
    Route::post('/admin/getUsersList','ProfileController@getUsersList')->name('admin.usersList');
    Route::post('/admin/deleteUser','ProfileController@deleteUser')->name('admin.deleteUser');

    
}); 
Route::group(['middleware' => ['isuser']], function () {
    Route::get('/user',function(){
        return view('user');
    });
    
  
});   
Route::group(['middleware' => ['auth']], function () {
   Route::get('/profile','ProfileController@index')->name('profile');
   Route::post('/updatePassword','ProfileController@updatePassword')->name('update.password');
   Route::post('/edit-profile', 'ProfileController@editProfile')->name('edit.profile');
   Route::post('/update-profile', 'ProfileController@updateProfile')->name('update.profile'); 
});