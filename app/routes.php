<?php
use Core\Route;

//middleware-> api
// Define your routes here

// fonts
Route::get('/', 'FontController@index');
Route::get('/api/fonts', 'FontController@list');
Route::post('/api/fonts/upload', 'FontController@upload');
Route::delete('/api/fonts/:id', 'FontController@destroy');
// fonts groups
Route::get('/api/font-groups', 'FontGroupController@index');
Route::post('/api/font-groups', 'FontGroupController@store');
Route::get('/api/font-groups/:id', 'FontGroupController@show');
Route::put('/api/font-groups/:id', 'FontGroupController@update');
Route::delete('/api/font-groups/:id', 'FontGroupController@destroy');




// Error handlers
Route::pathNotFound(function($path) {
    header('HTTP/1.0 404 Not Found');
    echo "404 - Page not found";
});

Route::methodNotAllowed(function($path, $method) {
    header('HTTP/1.0 405 Method Not Allowed');
    echo "405 - Method not allowed";
});