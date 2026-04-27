<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
 
class TaskController extends Controller {
    public function index(Request $request) {
        $q = Task::where('employee_id',auth()->id())->with('project');
        if ($request->search)   $q->where('titre','like',"%{$request->search}%");
        if ($request->status)   $q->where('status',$request->status);
        if ($request->priorite) $q->where('priorite',$request->priorite);
        $tasks = $q->latest()->paginate(15)->withQueryString();
        return view('employee.tasks.index', compact('tasks'));
    }
    public function show(Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        return view('employee.tasks.show', compact('task'));
    }
    public function update(Request $request, Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        $request->validate(['status'=>'required|in:à faire,en cours,terminé','commentaire'=>'nullable']);
        $task->update($request->only('status','commentaire'));
        return back()->with('success','Task updated.');
    }
}