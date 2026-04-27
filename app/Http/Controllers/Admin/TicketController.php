<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
 
class TicketController extends Controller {
    public function __construct() {
        $this->middleware('permission:ticket-list',  ['only' => ['index','show']]);
        $this->middleware('permission:ticket-reply', ['only' => ['reply']]);
        $this->middleware('permission:ticket-delete',['only' => ['destroy']]);
    }
    public function index(Request $request) {
        $q = Ticket::with('project','user','category');
        if ($request->search) $q->where('sujet','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        if ($request->priorite) $q->where('priorite',$request->priorite);
        $tickets = $q->latest()->paginate(15)->withQueryString();
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket) { return view('admin.tickets.show', compact('ticket')); }
    public function reply(Request $request, Ticket $ticket) {
        $request->validate(['response'=>'required|string']);
        $ticket->update(['response'=>$request->response,'status'=>'fermé']);
        return back()->with('success','Reply sent.');
    }
    public function destroy(Ticket $ticket) {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success','Ticket deleted.');
    }
}