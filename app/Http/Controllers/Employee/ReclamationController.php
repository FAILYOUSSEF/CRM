<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller {
    public function index() {
        $reclamations = Reclamation::where('user_id', auth()->id())->latest()->paginate(15);
        return view('employee.reclamations.index', compact('reclamations'));
    }
    public function create() { return view('employee.reclamations.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'nullable|string',
            'priorite'    => 'required|in:faible,moyenne,haute',
        ]);
        $data['user_id'] = auth()->id();
        $data['date']    = now()->toDateString();
        Reclamation::create($data);
        return redirect()->route('employee.reclamations.index')->with('success','Reclamation submitted.');
    }
    public function show(Reclamation $reclamation) {
        abort_if($reclamation->user_id !== auth()->id(), 403);
        return view('employee.reclamations.show', compact('reclamation'));
    }
}