<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateFontGroupsTable
{
    public static function up()
    {
        if (!Capsule::schema()->hasTable('font_groups')) {
            Capsule::schema()->create('font_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });

            echo "✅ font_groups table created successfully.\n";
        } else {
            echo "⚠️ font_groups table already exists.\n";
        }
    }

    // public static function modifyfont_groupsTable()
    // {
    //     Capsule::schema()->table('font_groups', function (Blueprint $table) {
    //         $table->string('phone')->nullable(); 
    //     });
    
    //     echo "✅column added successfully.\n";
    // }

    public static function down()
    {
        if (Capsule::schema()->hasTable('font_groups')) {
            Capsule::schema()->drop('font_groups');
            echo "✅ font_groups table dropped successfully.\n";
        }
    }
}
