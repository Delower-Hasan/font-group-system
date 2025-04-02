<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;



class FontGroupItem extends Eloquent {
    protected $table = 'font_group_items';
    public $timestamps = false; 

    protected $fillable = ['font_group_id','font_id','order'];
} 


