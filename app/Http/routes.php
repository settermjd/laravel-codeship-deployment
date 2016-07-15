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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Add a route for managing shortened urls
 *
 * This includes both viewing and processing the form, for adding
 * new shortened urls, and updating existing urls.
 */
Route::match(
    ['get', 'post'],
    '/manage-url/{uuid?}',
    'UrlController@manageUrl'
)->where(
    ['uuid' => '[a-f0-9\-]+']
)->name(
    'manage-route'
);

Route::get(
    '/view-urls',
    'UrlController@viewUrls'
)
->where(['uuid' => '[a-f0-9\-]+'])
->name('view-urls');
