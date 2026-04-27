<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;
 
class ReclamationController extends Controller {
    public function index(Request $request) {
        $q = Reclamation::where('user_id',auth()->id());
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        $reclamations = $q->latest()->paginate(15)->withQueryString();
        return view('employee.reclamations.index', compact('reclamations'));
    }
    public function create() { return view('employee.reclamations.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'=>'required','description'=>'required',
            'type'=>'required|in:meeting,bug,other',
            'type_other'=>'nullable|required_if:type,other',
            'priorite'=>'required|in:faible,moyenne,haute',
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