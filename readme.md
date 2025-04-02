# Database Setup Guide

## Step 1: Create a Database
1. Create a new database in your MySQL or PostgreSQL server.
2. Update the `config.php` file with the database name:
   ```php
   const DB_NAME = 'font_system';;
   ```

## Step 2: Install Dependencies
Run the following command to install the required dependencies using Composer:
```sh
composer install
```

## Step 3: Migrate the Schema
Execute the migration script to set up the database schema:
```sh
php app/config/migrate.php
```

