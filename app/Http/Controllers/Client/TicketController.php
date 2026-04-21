<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Categorie;
use Illuminate\Http\Request;

class TicketController extends Controller {
    public function index() {
        $tickets = Ticket::where('user_id', auth()->id())->with('project','category')->latest()->paginate(15);
        return view('client.tickets.index', compact('tickets'));
    }
    public function create() {
        $projects   = auth()->user()->clientProjects;
        $categories = Categorie::all();
        return view('client.tickets.create', compact('projects','categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'sujet'       => 'required|string|max:255',
            'message'     => 'required|string',
            'description' => 'nullable|string',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'deadline'    => 'nullable|date',
            'project_id'  => 'required|exists:projects,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $data['user_id'] = auth()->id();
        Ticket::create($data);
        return redirect()->route('client.tickets.index')->with('success','Ticket submitted.');
    }
    public function show(Ticket $ticket) {
        abort_if($ticket->user_id !== auth()->id(), 403);
        return view('client.tickets.show', compact('ticket'));
    }
}