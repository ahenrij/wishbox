<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/profile', 'UserController@profile')->name('profile');

Route::post('/connexion', 'LoginController@login')->name('login');
Route::post('/register', 'RegisterController@register')->name('register');

Route::resource('/wishbox', 'WishBoxController');
Route::resource('/giftbox', 'GiftBoxController');
Route::resource('/wish', 'WishController');
Route::resource('/category', 'CategoryController');
Route::resource('/comment', 'CommentController');


