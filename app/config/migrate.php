<?php

require __DIR__ . '/../../vendor/autoload.php';
require 'database.php';

// imports
require 'migrations/CreateFontsTable.php';
require 'migrations/CreateFontGroupsTable.php';
require 'migrations/CreateFontGroupItemsTable.php';

// Run migrations
CreateFontsTable::up();
CreateFontGroupsTable::up();
CreateFontGroupItemsTable::up();




// CreateFontsTable::modifyUsersTable();

// To drop tables, call:
// CreateFontsTable::down();
// CreateFontGroupsTable::down();
// CreateFontGroupItemsTable::down();