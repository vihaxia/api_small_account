<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = 'relation';

    public function record()
    {
        return $this->hasMany('App\Model\Record', 'id', 'relation_id');
    }
}
