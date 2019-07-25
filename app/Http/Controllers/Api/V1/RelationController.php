<?php

namespace App\Http\Controllers\Api\V1\Controller;

use App\Model\Relation;

class RelationController extends Controller
{

    public function index()
    {
        $relations = Relation::whereIn('user_id', [0, $this->userId])->with('record')->get();

        $newRelations = [];
        foreach ($relations as $relation) {
            if (count($relation->record)) {

            }
//            $newRelations[] =
//            dump($relation->record);
        }
//        if (isse)
//        foreach ($relations->record as $record) {
//            dump($record);
//        }
//        dump($relations);
    }
    
}
