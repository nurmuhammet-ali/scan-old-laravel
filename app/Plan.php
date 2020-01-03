<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = [];

    public function showTime() 
    {
        return $this->created_at->format('H:i:s, d.m.y');
    }
}
