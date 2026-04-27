<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Http\Request;
 
class ProjectController extends Controller {
    use Filterable;

    public function __construct() {
        $this->middleware('permission:project-list',   ['only' => ['index','show']]);
        $this->middleware('permission:project-create', ['only' => ['create','store']]);
        $this->middleware('permission:project-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        // Build query with advanced filtering
        $query = Project::with('client', 'employees')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('priorite'), fn($q) => $q->where('priorite', $request->input('priorite')))
            ->when($request->filled('client_id'), fn($q) => $q->where('client_id', $request->input('client_id')))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('date_debut', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('date_fin', '<=', $request->input('date_to')));

        $projects = $query->latest()->paginate(10)->withQueryString();

        // Prepare filter options for the view
        $filterOptions = [
            'status' => ['en cours', 'terminé', 'annulé'],
            'priority' => ['faible', 'moyenne', 'haute'],
            'clients' => User::where('type_client', 'client')->pluck('name', 'id'),
        ];

        return view('admin.projects.index', compact('projects', 'filterOptions'));
    }
    public function create() {
        $clients   = User::where('type_client','client')->get();
        $employees = User::where('type_client','employee')->get();
        return view('admin.projects.create', compact('clients','employees'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'=>'required|string|max:255','description'=>'nullable|string',
            'date_debut'=>'nullable|date','date_fin'=>'nullable|date',
            'status'=>'required|in:en cours,terminé,annulé',
            'priorite'=>'required|in:faible,moyenne,haute',
            'budget'=>'nullable|numeric','client_id'=>'nullable|exists:users,id',
            'employees'=>'nullable|array','progress'=>'nullable|integer|min:0|max:100',
            'ficher'=>'nullable|file|max:10240',
        ]);
        if ($request->hasFile('ficher')) $data['ficher'] = $request->file('ficher')->store('projects','public');
        $project = Project::create($data);
        if ($request->employees) $project->employees()->sync($request->employees);
        return redirect()->route('admin.projects.index')->with('success','Project created.');
    }
    public function show(Project $project) {
        $project->load('client','employees','tasks','tickets');
        return view('admin.projects.show', compact('project'));
    }
    public function edit(Project $project) {
        $clients   = User::where('type_client','client')->get();
        $employees = User::where('type_client','employee')->get();
        return view('admin.projects.edit', compact('project','clients','employees'));
    }
    public function update(Request $request, Project $project) {
        $data = $request->validate([
            'titre'=>'required|string|max:255','description'=>'nullable|string',
            'date_debut'=>'nullable|date','date_fin'=>'nullable|date',
            'status'=>'required|in:en cours,terminé,annulé',
            'priorite'=>'required|in:faible,moyenne,haute',
            'budget'=>'nullable|numeric','client_id'=>'nullable|exists:users,id',
            'employees'=>'nullable|array','progress'=>'nullable|integer|min:0|max:100',
            'ficher'=>'nullable|file|max:10240',
        ]);
        if ($request->hasFile('ficher')) $data['ficher'] = $request->file('ficher')->store('projects','public');
        $project->update($data);
        if ($request->has('employees')) $project->employees()->sync($request->employees ?? []);
        return redirect()->route('admin.projects.index')->with('success','Project updated.');
    }
    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success','Project deleted.');
    }
}