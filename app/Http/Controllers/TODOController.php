<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Task;
use Illuminate\Support\Facades\Auth;
class TODOController extends Controller
{
    
    public function index()
    {
        $todos = Task::where('user_id', Auth::id())->get();
        return response()->json($todos, 200);
    }

    protected function store(Request $request)
    {
        $request->validate([
            'text' => 'required|max:255',
            'priority' => 'required'
        ]);

        $task = Task::create([
            'text' => $request->text,
            'priority' => $request->priority,
            'completed' => 0,
            'user_id' => Auth::id() 
        ]);
    
        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {    
        $data = $request->all();
        $data['id'] = $id;

        $validator = Validator::make($data, [
            'text' => 'required|max:255',
            'completed' => 'required',
            'priority' => 'required',
            'id' => 'required|exists:tasks'
        ]);

        $validator->validate();
        $task = Task::findOrFail($id);
        $task->update($data);

        return response()->json(200);
    }
    
    public function destroy($id)
    {
        $data = array (
            'id' => $id
        );  
        $validator = Validator::make($data, [
            'id'=>'required|exists:tasks'
        ]);

        $validator->validate();
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(204);
    }
}
