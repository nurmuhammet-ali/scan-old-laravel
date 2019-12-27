<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    protected $guarded = [];

    public function plan() 
    {
        return Plan::find($this->plan);
    }

    public function removeUnNeeded($data) 
    {
        $retValue = '';

        $retValue = str_replace('00:00:00', '', $this->{$data});
        $retValue = str_replace(' ', '', $retValue);
        // $retValue = str_replace('  ', '', $retValue);

        return $retValue;
    }

    public function next() 
    {
        return Hosting::where('id', '>', $this->id)->orderBy('id','asc')->first();
    }

    public function previous()
    {
        return Hosting::where('id', '<', $this->id)->orderBy('id','desc')->first();
    }
}
