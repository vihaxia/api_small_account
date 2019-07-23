<?php

namespace App\Http\Controllers;

use App\Model\Relation;
use Illuminate\Http\Request;

class RelationController extends Controller
{

    public function index()
    {
        $relations = Relation::whereIn('user_id', [0, $this->userId])->with('record')->get();
        dump($relations);
    }
    
}
