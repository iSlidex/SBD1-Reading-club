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

Route::redirect('/', 'login');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*CLUBS*/
Route::resource('/browseclubs', 'clubs\BrowseClubsController');
Route::get('/browseclubs/{id}/editassociated', 'clubs\EditAssociatedController@edit');
Route::put('/browseclubs/{id}/editassociated', 'clubs\EditAssociatedController@update');
Route::get('/members', 'clubs\ReportsClubMembersController@index')->name('members');
Route::get('/clubreports', 'clubs\ClubReportsController@index')->name('clubreports');
Route::get('/selectclub', 'clubs\SelectClubController@index')->name('selectclub');
Route::get('/selectclubg', 'clubs\SelectClubController@group')->name('selectclub');
Route::get('/selectclubgm', 'clubs\SelectClubController@gm')->name('selectclub');
Route::get('/selectclubr', 'clubs\SelectClubController@r')->name('selectclub');
Route::get('/selectclubp', 'clubs\SelectClubController@pres')->name('selectclub');

/* MEMBERS */
Route::resource('/clubs/{club}/members', 'members\MembersController');
Route::get('/clubs/{club}/members/{member}/canAddPayment', 'members\MembersController@canAddPayment')->name('members.verify');

/* DELETE MEMBER FROM CLUB BUT NOT FROM DATABASE */
Route::patch('/clubs/{club}/deletemember/{id}', 'members\MembersController@delete')->name('members.changest');
Route::put('/clubs/{club}/deletemember/{id}', 'members\MembersController@delete')->name('members.changest');
Route::get('/clubs/{club}/deletemember/{id}', 'members\MembersController@delete')->name('members.changest');

/* MAKE FREE AGENT JOIN A NEW CLUB*/
Route::resource('/clubs/{clubs}/freeagent', 'members\FreeAgentController');
Route::get('clubs/{club}/freeagent/{member}/verify', 'members\FreeAgentController@verifyDay')->name('agent.verify');

/* PAYMENTS */
Route::resource('/clubs/{club}/members/{id}/payments', 'members\PagosController');

/*GROUPS*/
Route::resource('/clubs/{club}/groups', 'groups\BrowseGroupsController');
/* SPECIAL DELETE FOR GROUPS */
Route::patch('/clubs/{club}/delgroup/{grupo}', 'groups\BrowseGroupsController@borrar')->name('groups.borrar');
Route::put('/clubs/{club}/delgroup/{grupo}', 'groups\BrowseGroupsController@borrar')->name('groups.borrar');
Route::get('/clubs/{club}/delgroup/{grupo}', 'groups\BrowseGroupsController@borrar')->name('groups.borrar');
Route::get('/clubs/{club}/selectgm', 'groups\SelectGroupController@index')->name('selectgroup');
Route::get('/clubs/{club}/selectg', 'groups\SelectGroupController@r')->name('selectgroupr');

/* GROUP MEMBERS */
Route::resource('/clubs/{club}/groups/{group}/gmembers', 'groups\GroupMembersController');
Route::put('/clubs/{club}/groups/{group}/dropmember/{member}', 'groups\GroupMembersController@borrar')->name('gmembers.borrar');
Route::patch('/clubs/{club}/groups/{group}/dropmember/{member}', 'groups\GroupMembersController@borrar')->name('gmembers.borrar');
Route::get('/clubs/{club}/groups/{group}/dropmember/{member}', 'groups\GroupMembersController@borrar')->name('gmembers.borrar');


/* MEETINGS */
Route::resource('/clubs/{club}/groups/{group}/meetings', 'meetings\MeetingsController');
Route::get('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}/edit', 'meetings\MeetingsController@modificar')->name('meetings.modificar');
Route::get('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}', 'meetings\MeetingsController@concluir')->name('meetings.concluir');
Route::put('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}', 'meetings\MeetingsController@concluir')->name('meetings.concluir');
Route::patch('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}', 'meetings\MeetingsController@concluir')->name('meetings.concluir');
Route::get('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}/{sesion}/details', 'meetings\MeetingsController@details')->name('meetings.details');

/* ATTENDANCE */
Route::resource('/clubs/{club}/groups/{group}/meetings/{date}/{mod}/{libro}/attendance', 'meetings\AttendanceController');

Route::get('/managemeetings/calendar', 'meetings\MeetingsController@calendar')->name('managemeetings');


/* BOOKS */
Route::resource('/books', 'books\BooksController');
Route::resource('/books/{isbn}/structure', 'books\StructuresController');

/* FAVORITE BOOKS */
Route::resource('/clubs/{club}/members/{id}/favorites', 'members\FavoriteBooksController');

/* OBRAS */
Route::resource('/obras', 'obras\ObraController');
Route::resource('/obras/{obra}/personajes', 'obras\PersonajesController');

Route::resource('/clubs/{club}/presentaciones', 'obras\PresentacionController');
Route::resource('/clubs/{club}/locales', 'obras\LocalController');
Route::get('/clubs/{club}/presentaciones/{fec}/{obra}/{local}/edit', 'obras\PresentacionController@mod');
Route::put('/clubs/{club}/presentaciones/{fec}/{obra}/{local}', 'obras\PresentacionController@modificar');
Route::patch('/clubs/{club}/presentaciones/{fec}/{obra}/{local}', 'obras\PresentacionController@modificar');
Route::get('/clubs/{club}/presentaciones/{fec}/{obra}/{local}', 'obras\PresentacionController@modificar');
Route::delete('/clubs/{club}/presentaciones/{fec}/{obra}/{local}', 'obras\PresentacionController@borrar');
//Route::resource('/clubs/{club}/presentaciones/{fec}/{obra}/{local}/elenco', 'obras\ElencoController');
/*THEATER_PLAYS
Route::get('/playsclubs', 'theater_plays\PlaysClubsController@index')->name('playsclubs');
Route::get('/castplayss/{id}','theater_plays\CastPlaysController@obrasclub');
Route::get('charactercast/character_add', 'theater_plays\CastPlaysController@add'); 
Route::get('/charactercast', 'theater_plays\CharacterCastController@index')->name('charactercast');
Route::get('/earningplays', 'theater_plays\EarningPlaysController@index')->name('earningplays');
//Route::get('/browseplays', 'theater_plays\BrowsePlaysController@index')->name('browseplays');
Route::get('/charactercastadd', 'theater_plays\CharacterCastAddController@index')->name('charactercastadd');
//Route::resource('/castplays', 'theater_plays\CastPlaysController');
Route::resource('/castplays', 'theater_plays\playsController');

/*Performances*///{{$performance->id_club}}/{{$performance->id_obra}}/view
//Route::get('{id}/{id_obra}/perform/view','theater_plays\performancesController@details');
//Route::get('{id}/{id_obra}/perform/edit','theater_plays\performancesController@mod');
//Route::get('{id}/{id_obra}/perform/create','theater_plays\performancesController@create');
/*Route::post('/deleteperform/{id}/{id_obra}',[
    'as'=>'destroy',
    'uses'=> 'theater_plays\performancesController@destroy'
]);
Route::resource('{id}/{id_obra}/perform','theater_plays\performancesController');
//Route::resource('/clubs/{id}/plays/{id_obra}/performances','theater_plays\performancesController');*/
