<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $tasks = Task::where('employee_id', auth()->id())->with('project')->latest()->paginate(15);
        return view('employee.tasks.index', compact('tasks'));
    }
    public function show(Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        return view('employee.tasks.show', compact('task'));
    }
    public function update(Request $request, Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        $request->validate(['status' => 'required|in:à faire,en cours,terminé', 'commentaire' => 'nullable|string']);
        $task->update($request->only('status','commentaire'));
        return back()->with('success','Task updated.');
    }
}