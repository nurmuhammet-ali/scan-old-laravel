<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    protected $guarded = [];

    public function next() 
    {
        return Hosting::where('id', '>', $this->id)->orderBy('id','asc')->first();
    }

    public function previous()
    {
        return Hosting::where('id', '<', $this->id)->orderBy('id','desc')->first();
    }
}
