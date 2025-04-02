<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateFontsTable
{
    public static function up()
    {
        if (!Capsule::schema()->hasTable('fonts')) {
            Capsule::schema()->create('fonts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('filename');
                $table->string('path');
                $table->timestamps();
            });

            echo "✅ fonts table created successfully.\n";
        } else {
            echo "⚠️ fonts table already exists.\n";
        }
    }

    // public static function modifyfontsTable()
    // {
    //     Capsule::schema()->table('fonts', function (Blueprint $table) {
    //         $table->string('phone')->nullable(); 
    //     });
    
    //     echo "✅column added successfully.\n";
    // }

    public static function down()
    {
        if (Capsule::schema()->hasTable('fonts')) {
            Capsule::schema()->drop('fonts');
            echo "✅ fonts table dropped successfully.\n";
        }
    }
}
