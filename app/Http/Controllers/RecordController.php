<?php

namespace App\Http\Controllers;

use App\Model\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{

    public function index(Request $request)
    {

        $type = $request->has('type') ? $request->type : 1;

        if ($request->has('keyword')) {
            $relation = DB::table('relation')->where('name', 'like', '%'. $request->keyword. '%')->first();
            $event = DB::table('event')->where('name', 'like', '%'. $request->keyword. '%')->first();
            $records = DB::table('record')
                ->where([
                    ['user_id', '=', $this->userId],
                    ['type', '=', $type],
                    ['person', 'like', '%'. $request->keyword. '%'],
                ])
                ->when(isset($event->id), function ($query) use ($event) {
                    $query->orwhere('event_id', $event->id);
                })
                ->when(isset($relation->id), function ($query) use ($relation) {
                    $query->orwhere('relation_id', $relation->id);
                })
                ->get();
        } else {
            $records = Record::where(['user_id' => $this->userId, 'type' => $type])->get();
        }

        $money = 0;
        foreach ($records as $record) {
            $money += $record->money;
        }

        return json_encode(['code' => 0, 'data' => $records, 'money' => ($money / 100)]);

    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
