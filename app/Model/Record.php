<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'record';

    public function relation()
    {
        return $this->belongsTo('App\Model\Relation', 'id', 'relation_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Model\Event', 'id', 'event_id');
    }
    
}
