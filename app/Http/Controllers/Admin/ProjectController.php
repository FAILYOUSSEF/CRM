<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller {
    public function index() {
        $projects = Project::with('client','employees')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }
    public function create() {
        $clients   = User::where('type_client','client')->get();
        $employees = User::where('type_client','employee')->get();
        return view('admin.projects.create', compact('clients','employees'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_duree'  => 'nullable|date',
            'date_fin'    => 'nullable|date',
            'status'      => 'required|in:en cours,terminé,annulé',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'budget'      => 'nullable|numeric',
            'client_id'   => 'nullable|exists:users,id',
            'employees'   => 'nullable|array',
            'ficher'      => 'nullable|file|max:10240',
        ]);
        if ($request->hasFile('ficher')) {
            $data['ficher'] = $request->file('ficher')->store('projects','public');
        }
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
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_duree'  => 'nullable|date',
            'date_fin'    => 'nullable|date',
            'status'      => 'required|in:en cours,terminé,annulé',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'budget'      => 'nullable|numeric',
            'client_id'   => 'nullable|exists:users,id',
            'employees'   => 'nullable|array',
            'ficher'      => 'nullable|file|max:10240',
        ]);
        if ($request->hasFile('ficher')) {
            $data['ficher'] = $request->file('ficher')->store('projects','public');
        }
        $project->update($data);
        if ($request->has('employees')) $project->employees()->sync($request->employees);
        return redirect()->route('admin.projects.index')->with('success','Project updated.');
    }
    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success','Project deleted.');
    }
}