<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\User;
use Auth;

class TaskController extends Controller {

    //property of class TaskController
    protected $model;

    //Create a new TaskController instance
    public function __construct(Task $task) {
        $this->middleware('auth');
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
       
        return view('tasks.index', ['tasks' => $tasks]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        
        $task = new Task([
            'task_name' => $request->task_name,
            'due_date' => $request->due_date
        ]);
        $user = Auth::user();
        $user->tasks()->save($task);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        //return response and check request and id values
        DB::table('tasks')
                ->where('id', $id)
                ->update([
                    'task_name' => $request->task_name,
                    'due_date' => $request->due_date
        ]);

        $task = new Task;
        $task->task_name = $request->task_name;
        $task->due_date = $request->due_date;
        
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $task = Task::find($id);
        $task->delete();
        return response()->json('ok');
    }
}
