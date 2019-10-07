<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/association_list', ['uses' => 'Controller@association_list', 'as' => 'association_list']);
Route::get('/', ['uses' => 'Controller@index', 'as' => 'index']);
Route::post('/vote_association', ['uses' => 'Controller@vote_association', 'as' => 'vote_association']);
Route::get('/association_info', ['uses' => 'Controller@association_info', 'as' => 'association_info']);
Route::get('/get_last_ticket', ['uses' => 'Controller@get_last_ticket', 'as' => 'get_last_ticket']);
