<?php

require __DIR__ . '/../../vendor/autoload.php';
require 'database.php';



// imports
require 'migrations/CreateUsersTable.php';

// Run migrations
CreateUsersTable::up();
// CreateUsersTable::modifyUsersTable();


// To drop tables, call:
// CreateUsersTable::down();
