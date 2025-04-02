<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\FontGroup;

class Font extends Eloquent {
    protected $table = 'fonts';
    public $timestamps = true; 

    public function groups()
    {
        return $this->belongsToMany(FontGroup::class, 'font_group_items')
            ->withPivot('order')
            ->orderBy('order');
    }

    protected $fillable = ['name','path','filename'];
} 

