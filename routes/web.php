<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'IndexController@index')->name('index');
Route::get('/search', 'SearchController@search')->name('search');
Route::post('/contact', 'ContactController@storeData')->name('contact');
Route::get('/contact', 'ContactController@show')->name('show');
Route::get('/banned', 'BannedController@banned')->name('banned');


/* PROFILE ROUTES */
Route::get('/profile', 'Profile\ProfileController@profile')->name('profile');

Route::get('/city', 'Profile\CityController@index')->name('city');
Route::post('/city/{id}', 'Profile\CityController@edit')->name('city-change');

Route::get('/image', 'Profile\ImageController@index')->name('image');
Route::post('/image/{id}', 'Profile\ImageController@edit')->name('image-change');

Route::get('/password', 'Profile\PasswordController@index')->name('password');
Route::post('/password/{id}', 'Profile\PasswordController@edit')->name('password-change');

Route::get('/phone', 'Profile\PhoneController@index')->name('phone');
Route::post('/phone/{id}', 'Profile\PhoneController@edit')->name('phone-change');

Route::get('/price', 'Profile\PriceController@index')->name('price');
Route::post('/price/{id}', 'Profile\PriceController@edit')->name('price-change');

Route::get('/category', 'Profile\CategoryController@index')->name('category');
Route::post('/category/{id}', 'Profile\CategoryController@edit')->name('category-change');

Route::get('/msg-title', 'Profile\MessageController@title')->name('msg-title');
Route::post('/msg-title/{id}', 'Profile\MessageController@edit_title')->name('msg-title-change');
Route::get('/msg-body', 'Profile\MessageController@body')->name('msg-body');
Route::post('/msg-body/{id}', 'Profile\MessageController@edit_body')->name('msg-body-change');


/* COACH ROUTES */
Route::get('/coach/finish', 'Coach\RegisterController@showFinishRegistration')->name('show-finish-registration');
Route::post('/coach', 'Coach\RegisterController@storeFinishRegistration')->name('store-finish-registration');

Route::get('/coach/home', 'Coach\PageController@home')->name('coach-home');
Route::get('/coach/public/{coach_id}/{params}', 'Coach\PageController@public')->name('public-profile');


/* USER ROUTES */
Route::get('/user/home', 'User\PageController@index')->name('user-home');
Route::post('/coach/review/{params}', 'User\ReviewController@create')->name('create-review');


/* RELATION ROUTES */
Route::post('/relation/{user_id}/{coach_id}/{params}', 'RelationController@relation_request')->name('relation-request');
Route::post('/relation/cancel/{relation_id}/{coach_id}/{params}', 'RelationController@cancel_request')->name('cancel-request');
Route::post('/relation/restore/{relation_id}/{coach_id}/{params}', 'RelationController@restore_request')->name('restore-request');
Route::post('/relation/finish/{relation_id}/{coach_id}/{params}', 'RelationController@finish_relation')->name('finish-relation');
Route::post('/coach/home/{relation_id}', 'RelationController@accept_relation')->name('accept-relation');
Route::post('/coach/delete/{relation_id}', 'RelationController@delete_relation')->name('delete-relation');
Route::get('/relation/sender/{relation_id}/{param}', 'RelationController@senders_info')->name('sender-info');
Route::get('/relation/active', 'RelationController@active_relations')->name('active-relations');
Route::get('/relation/finished', 'RelationController@finished_relations')->name('finished-relations');


//NOTES ROUTE
Route::get('/notes', 'NotesController@index')->name('show-notes');
Route::post('/notes/{param}/sore', 'NotesController@store_note')->name('store-note');
Route::post('/notes/{note_id}/{param}/edit', 'NotesController@edit_note')->name('edit-note');
Route::post('/notes/{note_id}/{param}/finish', 'NotesController@finish_note')->name('finish-note');
Route::post('/notes/{note_id}/{param}/delete', 'NotesController@delete_note')->name('delete-note');


/* MESSAGES ROUTES */
Route::get('/messages', 'PrivateMessageController@index')->name('private-messages');
Route::get('/messages/{conversation_id}', 'PrivateMessageController@show_messages')->name('show-messages');
Route::get('/messages/administration/{reply_id}', 'PrivateMessageController@show_admin_messages')->name('show-admin-messages');
Route::post('/messages/create', 'PrivateMessageController@create_conversation')->name('create-new-conversation');
Route::post('/messages/reply', 'PrivateMessageController@reply_message')->name('reply-message');
Route::post('/messages/delete/{conversation_id}', 'PrivateMessageController@delete_conversation')->name('delete-conversation');
Route::post('/messages/administration/{reply_id}', 'PrivateMessageController@delete_admin_message')->name('delete-admin-message');


/* ADMINISTRATION ROUTES */
Route::get('/admin/home', 'Admin\HomeController@index')->name('superadmin-home');

Route::get('/admin/categories', 'Admin\CategoryController@index')->name('superadmin-categories');
Route::post('/admin/categories', 'Admin\CategoryController@store')->name('store-categories');
Route::post('/admin/categories/{id}/edit', 'Admin\CategoryController@edit')->name('edit-categories');
Route::post('/admin/categories/{id}/disable', 'Admin\CategoryController@disable')->name('disable-categories');
Route::post('/admin/categories/{id}/delete', 'Admin\CategoryController@delete')->name('delete-categories');

Route::get('/admin/mot-msgs', 'Admin\MotivationController@index')->name('superadmin-mot-msgs');
Route::post('/admin/mot-msgs', 'Admin\MotivationController@store')->name('store-mot-msgs');
Route::post('/admin/mot-msgs/{id}/edit', 'Admin\MotivationController@edit')->name('edit-mot-msgs');
Route::post('/admin/mot-msgs/{id}/delete', 'Admin\MotivationController@delete')->name('delete-mot-msgs');

Route::get('/admin/cont-msgs', 'Admin\ContactController@index')->name('superadmin-cont-msgs');
Route::get('/admin/cont-msgs/{id}/read', 'Admin\ContactController@read')->name('read-cont-msgs');
Route::post('/admin/cont-msgs/{id}/reply', 'Admin\ContactController@reply')->name('reply-cont-msgs');
Route::get('/admin/deleted', 'Admin\ContactController@deleted')->name('deleted-cont-msgs');
Route::post('/admin/cont-msgs/{id}/delete', 'Admin\ContactController@delete')->name('delete-cont-msgs');

Route::get('/admin/users', 'Admin\UserController@index')->name('superadmin-users');

Route::get('/admin/coaches', 'Admin\CoachController@index')->name('superadmin-coaches');

Route::get('/admin/banned', 'Admin\BannedController@index')->name('superadmin-banned');

Route::post('/admin/users/{id}/set', 'Admin\ActionController@setAdmin')->name('set-admin-users');
Route::post('/admin/users/{id}/ban', 'Admin\ActionController@banUser')->name('ban-users');

Route::get('/admin/password', 'Admin\PassController@index')->name('superadmin-password');
Route::post('/admin/password{id}/edit', 'Admin\PassController@edit')->name('update-admin-password');

Route::get('/admin/relations', 'Admin\RelationController@index')->name('superadmin-relations');
Route::get('/admin/active/relations', 'Admin\RelationController@active_relations')->name('superadmin-active-relations');








