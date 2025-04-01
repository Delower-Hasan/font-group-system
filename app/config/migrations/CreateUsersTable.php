<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable
{
    public static function up()
    {
        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamps();
            });

            echo "✅ Users table created successfully.\n";
        } else {
            echo "⚠️ Users table already exists.\n";
        }
    }

    public static function modifyUsersTable()
    {
        Capsule::schema()->table('users', function (Blueprint $table) {
            $table->string('phone')->nullable(); 
        });
    
        echo "✅column added successfully.\n";
    }

    public static function down()
    {
        if (Capsule::schema()->hasTable('users')) {
            Capsule::schema()->drop('users');
            echo "✅ Users table dropped successfully.\n";
        }
    }
}
