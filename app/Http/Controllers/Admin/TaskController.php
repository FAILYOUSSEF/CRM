<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Http\Request;
 
class TaskController extends Controller {
    use Filterable;

    public function __construct() {
        $this->middleware('permission:task-list',   ['only' => ['index','show']]);
        $this->middleware('permission:task-create', ['only' => ['create','store']]);
        $this->middleware('permission:task-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        // Build query with advanced filtering
        $query = Task::with('project', 'employee')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('priorite'), fn($q) => $q->where('priorite', $request->input('priorite')))
            ->when($request->filled('project_id'), fn($q) => $q->where('project_id', $request->input('project_id')))
            ->when($request->filled('employee_id'), fn($q) => $q->where('employee_id', $request->input('employee_id')))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('date_debut', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('date_fin', '<=', $request->input('date_to')));

        $tasks = $query->latest()->paginate(15)->withQueryString();

        // Prepare filter options for the view
        $filterOptions = [
            'status' => ['à faire', 'en cours', 'terminé'],
            'priority' => ['faible', 'moyenne', 'haute'],
            'projects' => Project::orderBy('titre')->pluck('titre', 'id'),
            'employees' => User::where('type_client', 'employee')->orderBy('name')->pluck('name', 'id'),
        ];

        return view('admin.tasks.index', compact('tasks', 'filterOptions'));
    }
    public function create() {
        $projects  = Project::all();
        $employees = User::where('type_client','employee')->get();
        return view('admin.tasks.create', compact('projects','employees'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'=>'required','description'=>'nullable','date_debut'=>'nullable|date',
            'duree'=>'nullable|integer','priorite'=>'required|in:faible,moyenne,haute',
            'status'=>'required|in:à faire,en cours,terminé',
            'date_fin'=>'nullable|date','commentaire'=>'nullable',
            'employee_id'=>'nullable|exists:users,id','project_id'=>'required|exists:projects,id',
        ]);
        Task::create($data);
        return redirect()->route('admin.tasks.index')->with('success','Task created.');
    }
    public function show(Task $task) { return view('admin.tasks.show', compact('task')); }
    public function edit(Task $task) {
        $projects  = Project::all();
        $employees = User::where('type_client','employee')->get();
        return view('admin.tasks.edit', compact('task','projects','employees'));
    }
    public function update(Request $request, Task $task) {
        $data = $request->validate([
            'titre'=>'required','description'=>'nullable','date_debut'=>'nullable|date',
            'duree'=>'nullable|integer','priorite'=>'required|in:faible,moyenne,haute',
            'status'=>'required|in:à faire,en cours,terminé',
            'date_fin'=>'nullable|date','commentaire'=>'nullable',
            'employee_id'=>'nullable|exists:users,id','project_id'=>'required|exists:projects,id',
        ]);
        $task->update($data);
        return redirect()->route('admin.tasks.index')->with('success','Task updated.');
    }
    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success','Task deleted.');
    }
}