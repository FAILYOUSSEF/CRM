<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $tasks = Task::with('project','employee')->latest()->paginate(15);
        return view('admin.tasks.index', compact('tasks'));
    }
    public function create() {
        $projects  = Project::all();
        $employees = User::where('type_client','employee')->get();
        return view('admin.tasks.create', compact('projects','employees'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut'  => 'nullable|date',
            'duree'       => 'nullable|integer',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'status'      => 'required|in:à faire,en cours,terminé',
            'date_fin'    => 'nullable|date',
            'commentaire' => 'nullable|string',
            'employee_id' => 'nullable|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
        ]);
        Task::create($data);
        return redirect()->route('admin.tasks.index')->with('success','Task created.');
    }
    public function show(Task $task) {
        return view('admin.tasks.show', compact('task'));
    }
    public function edit(Task $task) {
        $projects  = Project::all();
        $employees = User::where('type_client','employee')->get();
        return view('admin.tasks.edit', compact('task','projects','employees'));
    }
    public function update(Request $request, Task $task) {
        $data = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut'  => 'nullable|date',
            'duree'       => 'nullable|integer',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'status'      => 'required|in:à faire,en cours,terminé',
            'date_fin'    => 'nullable|date',
            'commentaire' => 'nullable|string',
            'employee_id' => 'nullable|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
        ]);
        $task->update($data);
        return redirect()->route('admin.tasks.index')->with('success','Task updated.');
    }
    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success','Task deleted.');
    }
}