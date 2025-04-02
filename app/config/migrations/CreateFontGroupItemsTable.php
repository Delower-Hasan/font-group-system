<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateFontGroupItemsTable
{
    public static function up()
    {
        if (!Capsule::schema()->hasTable('font_group_items')) {
            Capsule::schema()->create('font_group_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('font_group_id')->constrained()->onDelete('cascade');
                $table->foreignId('font_id')->constrained();
                $table->integer('order')->default(0);
                $table->timestamps();
            });

            echo "✅ font_group_items table created successfully.\n";
        } else {
            echo "⚠️ font_group_items table already exists.\n";
        }
    }

    // public static function modifyfont_group_itemsTable()
    // {
    //     Capsule::schema()->table('font_group_items', function (Blueprint $table) {
    //         $table->string('phone')->nullable(); 
    //     });
    
    //     echo "✅column added successfully.\n";
    // }

    public static function down()
    {
        if (Capsule::schema()->hasTable('font_group_items')) {
            Capsule::schema()->drop('font_group_items');
            echo "✅ font_group_items table dropped successfully.\n";
        }
    }
}
