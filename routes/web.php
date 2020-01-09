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

Route::post('/users', 'SearchController@index')->name('search');
Route::post('/userProfile', 'SearchController@profile')->name('user.profile');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/profile', 'UserController@profile')->name('profile');

Route::get('/wishbox-pending/{wishBox}', 'WishBoxController@showPendings')->name('wishbox.show.pending');
Route::get('/giftbox-pending/{wishBox}', 'WishBoxController@showPendings')->name('giftbox.show.pending');

Route::get('/wish/received/{wish}', 'WishController@receivedWish')->name('wish.received');
Route::get('/gift/received/{wish}', 'WishController@receivedGift')->name('gift.received');

Route::get('/giftbox/get/{wish}', 'WishController@obtainGift')->name('gift.get');
Route::get('/giftbox/offer/{wish}/{user_id}', 'WishController@offerGift')->name('wish.offer.gift');

Route::get('/wishbox/published', 'WishBoxController@others')->name('wishbox.others');
Route::get('/giftbox/published', 'WishBoxController@others')->name('giftbox.others');

Route::get('/wishbox/offer/{wish}', 'WishController@offerWish')->name('wish.offer.wish');
//Route::get('/wishbox/{user}/email-giver', 'WishController@sendMail')->name('wish.sendMail');

Route::get('/user/{id}', 'UserController@show')->name('user.show');

Route::resource('/giftbox', 'WishBoxController');
Route::resource('/wishbox', 'WishBoxController');
Route::resource('/wish', 'WishController');
Route::resource('/gift', 'WishController');
Route::resource('/category', 'CategoryController');
Route::resource('/comment', 'CommentController');

Route::post('/selectTheme', 'UserController@selectTheme')->name('selectTheme');

Route::get('profile/{user}/edit',  'UserController@edit')->name('users.edit');
Route::patch('profile/{user}/update',  'UserController@update')->name('users.update');
