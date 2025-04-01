<?php
use Core\Route;

//middleware-> api
// Define your routes here
Route::get('/', 'HomeController@index');
Route::get('/about/:id', 'HomeController@about');
Route::post('/api/create', 'HomeController@create');


// Error handlers
Route::pathNotFound(function($path) {
    header('HTTP/1.0 404 Not Found');
    echo "404 - Page not found";
});

Route::methodNotAllowed(function($path, $method) {
    header('HTTP/1.0 405 Method Not Allowed');
    echo "405 - Method not allowed";
});