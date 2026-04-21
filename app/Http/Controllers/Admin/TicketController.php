<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\Categorie;
use Illuminate\Http\Request;

class TicketController extends Controller {
    public function index() {
        $tickets = Ticket::with('project','user','category')->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket) {
        return view('admin.tickets.show', compact('ticket'));
    }
    public function reply(Request $request, Ticket $ticket) {
        $request->validate(['reponce' => 'required|string']);
        $ticket->update(['reponce' => $request->reponce, 'status' => 'fermé']);
        return back()->with('success','Reply sent.');
    }
    public function destroy(Ticket $ticket) {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success','Ticket deleted.');
    }
}