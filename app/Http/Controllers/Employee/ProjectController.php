<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
 
class ProjectController extends Controller {
    public function index(Request $request) {
        $q = auth()->user()->projects()->with('client','tasks');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        $projects = $q->paginate(10)->withQueryString();
        return view('employee.projects.index', compact('projects'));
    }
    public function show(Project $project) {
        abort_unless(auth()->user()->projects->contains($project->id), 403);
        $project->load('client','tasks','employees');
        return view('employee.projects.show', compact('project'));
    }
    public function edit(Project $project) {
        abort_unless(auth()->user()->projects->contains($project->id), 403);
        return view('employee.projects.edit', compact('project'));
    }
    public function update(Request $request, Project $project) {
        abort_unless(auth()->user()->projects->contains($project->id), 403);
        $data = $request->validate([
            'status'=>'required|in:en cours,terminé,annulé',
            'progress'=>'nullable|integer|min:0|max:100',
        ]);
        $project->update($data);
        return redirect()->route('employee.projects.show',$project)->with('success','Project updated.');
    }
}