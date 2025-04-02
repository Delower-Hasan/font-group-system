<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;



class FontGroup extends Eloquent {
    protected $table = 'font_groups';
    public $timestamps = false; 

    protected $fillable = ['name'];

    public function fonts()
    {
        return $this->belongsToMany(Font::class, 'font_group_items')
            ->withPivot('order')
            ->orderBy('order');
    }
} 


