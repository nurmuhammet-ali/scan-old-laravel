<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];

    public function hosting() 
    {
        return $this->belongsTo(Hosting::class);
    }
}
