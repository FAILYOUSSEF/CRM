<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Categorie;
use App\Models\Project;
use Illuminate\Http\Request;
 
class TicketController extends Controller {
    public function index(Request $request) {
        $q = Ticket::where('user_id',auth()->id())->with('project','category');
        if ($request->search) $q->where('sujet','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        $tickets = $q->latest()->paginate(15)->withQueryString();
        return view('client.tickets.index', compact('tickets'));
    }
    public function create() {
        // Only completed projects
        $projects   = auth()->user()->clientProjects()->where('status','terminé')->get();
        $categories = Categorie::all();
        return view('client.tickets.create', compact('projects','categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'sujet'=>'required','message'=>'required','description'=>'nullable',
            'priorite'=>'required|in:faible,moyenne,haute',
            'deadline'=>'nullable|date','project_id'=>'required|exists:projects,id',
            'category_id'=>'nullable|exists:categories,id',
        ]);
        
        // Check project is completed
        $project = Project::findOrFail($request->project_id);
        if ($project->client_id !== auth()->id() || $project->status !== 'terminé') {
            return back()->with('error','You can only submit tickets for completed projects.');
        }
        $data['user_id'] = auth()->id();
        Ticket::create($data);
        return redirect()->route('client.tickets.index')->with('success','Ticket submitted.');
    }
    public function show(Ticket $ticket) {
        abort_if($ticket->user_id !== auth()->id(), 403);
        return view('client.tickets.show', compact('ticket'));
    }
}