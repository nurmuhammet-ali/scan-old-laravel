<?php

namespace App;

use App\Events\{TypeCreated, TypeUpdated, TypeDeleted};
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TypeCreated::class,
        'updated' => TypeUpdated::class,
        'deleted' => TypeDeleted::class
    ];    
}
