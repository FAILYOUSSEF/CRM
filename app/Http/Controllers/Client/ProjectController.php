<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
 
class ProjectController extends Controller {
    public function index(Request $request) {
        $q = auth()->user()->clientProjects()->with('employees','tasks');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        $projects = $q->paginate(10)->withQueryString();
        return view('client.projects.index', compact('projects'));
    }
    public function show(Project $project) {
        abort_if($project->client_id !== auth()->id(), 403);
        $project->load('employees','tasks','tickets');
        return view('client.projects.show', compact('project'));
    }
}