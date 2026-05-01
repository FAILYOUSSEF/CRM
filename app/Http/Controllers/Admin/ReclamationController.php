<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Http\Request;
 
class ReclamationController extends Controller {
    use Filterable;

    public function __construct() {
        $this->middleware('permission:reclamation-list',   ['only' => ['index', 'show']]);
        $this->middleware('permission:reclamation-reply',  ['only' => ['reply']]);
        $this->middleware('permission:reclamation-assign', ['only' => ['assign']]);
        $this->middleware('permission:reclamation-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request) {
        // Build query with advanced filtering
        $query = Reclamation::with('user', 'assignedTo')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->input('type')))
            ->when($request->filled('priorite'), fn($q) => $q->where('priorite', $request->input('priorite')))
            ->when($request->filled('assigned_to'), fn($q) => $q->where('assigned_to', $request->input('assigned_to')))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('date', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('date', '<=', $request->input('date_to')));

        $reclamations = $query->latest()->paginate(15)->withQueryString();

        // Get available types (from Reclamation model or config)
        $types = Reclamation::distinct()->whereNotNull('type')->pluck('type')->unique()->sort()->values()->toArray();
        
        // Prepare filter options for the view
        $filterOptions = [
            'status' => ['en attente', 'traité', 'résolu'],
            'priority' => ['faible', 'moyenne', 'haute', 'critique'],
            'types' => $types,
            'employees' => User::where('type_client', 'employee')->orderBy('name')->pluck('name', 'id'),
        ];

        return view('admin.reclamations.index', compact('reclamations', 'filterOptions'));
    }
    public function create() {
        $users = User::whereIn('type_client', ['employee', 'client'])->orderBy('name')->get();
        return view('admin.reclamations.create', compact('users'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'type_other' => 'nullable|string|max:255',
            'priorite' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->id();
        $data['date'] = now()->toDateString();

        Reclamation::create($data);

        return redirect()->route('admin.reclamations.index')->with('success', 'Reclamation created.');
    }

    public function show(Reclamation $reclamation) {
        $employees = User::where('type_client','employee')->get();
        return view('admin.reclamations.show', compact('reclamation','employees'));
    }

    public function edit(Reclamation $reclamation) {
        $users = User::whereIn('type_client', ['employee', 'client'])->orderBy('name')->get();
        return view('admin.reclamations.edit', compact('reclamation', 'users'));
    }

    public function update(Request $request, Reclamation $reclamation) {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'type_other' => 'nullable|string|max:255',
            'priorite' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|string|max:255',
        ]);

        $reclamation->update($data);

        return redirect()->route('admin.reclamations.show', $reclamation)->with('success', 'Reclamation updated.');
    }
    public function reply(Request $request, Reclamation $reclamation) {
        $request->validate(['response'=>'required|string']);
        $reclamation->update(['response'=>$request->response,'status'=>'traité']);
        return back()->with('success','Reply sent.');
    }
    public function assign(Request $request, Reclamation $reclamation) {
        $request->validate(['assigned_to'=>'required|exists:users,id']);
        $reclamation->update(['assigned_to'=>$request->assigned_to]);
        return back()->with('success','Employee assigned.');
    }
    public function destroy(Reclamation $reclamation) {
        $reclamation->delete();
        return redirect()->route('admin.reclamations.index')->with('success','Deleted.');
    }
}