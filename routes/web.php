<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| routes are loaded by the RouteServiceProvider within a group whic
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/{page?}', 'WelcomeController@index')->where(['page' => '[0-9]+']);
Route::get('/poll/{slug?}', 'WelcomeController@viewExactPublicPoll');
Route::post('/poll/', 'WelcomeController@voteExactPublicPoll');
Route::post('/', 'WelcomeController@votePollAjax');
Route::post( '/results/{id?}', 'WelcomeController@resultsPollAjax');


Auth::routes();

Route::get('/home/{page?}', 'HomeController@index');
Route::post('/home', 'WelcomeController@votePollAjax');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('/confirm-account/{token?}', 'Auth\ConfirmController@index');
Route::get('/must-confirm', 'Auth\ConfirmController@mustConfirm');

Route::get('/profile', 'User\UserController@viewUserProfile');
Route::get('/profile/edit/{id?}', 'User\UserController@viewEditProfile');
Route::post('/profile/edit/{id?}', 'User\UserController@editProfile');
Route::get('/profile/delete/{id?}', 'User\UserController@viewDeleteUser');
Route::post('/profile/delete/{id?}', 'User\UserController@deleteUser');
Route::match(['get', 'post'], '/profile/{id?}', 'User\UserController@viewExactProfile');



Route::get('/polls/create/{id?}', 'Pool\PoolsController@viewCreatePoll');
Route::post('/polls/create/{id?}', 'Pool\PoolsController@createPoll');
Route::get('/polls/delete/{id?}', 'Pool\PoolsController@viewDeletePoll');
Route::post('/polls/delete/{id?}', 'Pool\PoolsController@deletePoll');
Route::match(['get', 'post'], '/polls/mine', 'Pool\PoolsController@minePolls');
Route::get('/polls/voted', 'Pool\PoolsController@votedPolls');



Route::get('/groups/create/{id?}', 'Groups\GroupsController@viewCreateGroup');
Route::post('/groups/create/{id?}', 'Groups\GroupsController@createGroup');
Route::get('/groups/mine', 'Groups\GroupsController@listMineGroups');
Route::get('/groups/participate', 'Groups\GroupsController@listPartGroups');
Route::get('/groups/delete/{id?}', 'Groups\GroupsController@viewDeleteGroup');
Route::post('/groups/delete/{id?}', 'Groups\GroupsController@deleteGroup');
Route::get('/group/{id?}', 'Groups\GroupsController@viewExactGroup');


Route::match(['get', 'post'], '/listing/members/{search?}', 'User\UserController@viewMemberListing');
Route::match(['get', 'post'], '/listing/admins/{search?}', 'User\UserController@viewAdminListing');


Route::match(['get', 'post'], 'message/{id}', 'Message\MessageController@readMessage');
Route::get('/messages/recieved/read/{page?}{id?}', 'Message\MessageController@listReadRecievedMessages');
Route::get('/messages/recieved/unread/{page?}{id?}', 'Message\MessageController@listUnreadRecievedMessages');
Route::get('/messages/sent/read/{page?}{id?}', 'Message\MessageController@listReadSentMessages');
Route::get('/messages/sent/unread/{page?}{id?}', 'Message\MessageController@listUnreadSentMessages');
Route::get('/messages/{id?}', 'Message\MessageController@Messages');
Route::post('/messages/{id?}', 'Message\MessageController@postMessages');
