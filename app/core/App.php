<?php
// app/core/App.php

namespace Core;

class App {
    public function __construct() {
        // Load Route class first
        
        // Then load routes
        require_once __DIR__.'/../routes.php';
        
        // Run the router
        Route::run('/project');
    }
}