<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
class TODOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'tasks' =>Task::all()->jsonSerialize()
        ], 200);

    }
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request)
    {
        $task = Task::create([
            'name' => $request->name,
            'text' => $request->text,
            'priority' => $request->priority,
        ]);
        return response()->json([
            'task' => $task,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        $task = Task::where('name', '=', $name)->firstOrFail();

        // change the attribute
        $task->text = $request->text;
        $task->priority = $request->priority;
        //$task->priority = $request->priority;
        $task->save();
        return response()->json([
            'message' => 'Updated'
        ], 200);
    }
    public function create(Request $request)
    {
        
        $task = Task::create([
            'name' => $request->name,
            'text' => $request->text,
            'priority' => $request->priority,
        ]);
        return response()->json([
            'task' => $task,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $task = Task::where('name', $name)->firstOrFail();
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully!'
        ], 200);

    }
}
