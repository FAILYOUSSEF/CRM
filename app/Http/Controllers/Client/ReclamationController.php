<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Traits\Filterable;
use Illuminate\Http\Request;
 
class ReclamationController extends Controller {
    use Filterable;

    public function index(Request $request) {
        // Build query with advanced filtering
        $query = Reclamation::where('user_id', auth()->id())
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
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('date', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('date', '<=', $request->input('date_to')));

        $reclamations = $query->latest()->paginate(15)->withQueryString();

        // Get available types
        $types = Reclamation::where('user_id', auth()->id())
            ->distinct()
            ->whereNotNull('type')
            ->pluck('type')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Prepare filter options for the view
        $filterOptions = [
            'status' => ['en attente', 'traité', 'résolu'],
            'priority' => ['faible', 'moyenne', 'haute', 'critique'],
            'types' => $types,
        ];

        return view('client.reclamations.index', compact('reclamations', 'filterOptions'));
    }
    public function create() { return view('client.reclamations.create'); }
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
        return redirect()->route('client.reclamations.index')->with('success','Reclamation submitted.');
    }
    public function show(Reclamation $reclamation) {
        abort_if($reclamation->user_id !== auth()->id(), 403);
        return view('client.reclamations.show', compact('reclamation'));
    }
}