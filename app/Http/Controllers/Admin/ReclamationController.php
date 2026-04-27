<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Http\Request;
 
class ReclamationController extends Controller {
    public function __construct() {
        $this->middleware('permission:reclamation-list',   ['only' => ['index', 'show']]);
        $this->middleware('permission:reclamation-reply',  ['only' => ['reply']]);
        $this->middleware('permission:reclamation-assign', ['only' => ['assign']]);
        $this->middleware('permission:reclamation-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        $q = Reclamation::with('user','assignedTo');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        if ($request->type)   $q->where('type',$request->type);
        $reclamations = $q->latest()->paginate(15)->withQueryString();
        return view('admin.reclamations.index', compact('reclamations'));
    }
    public function show(Reclamation $reclamation) {
        $employees = User::where('type_client','employee')->get();
        return view('admin.reclamations.show', compact('reclamation','employees'));
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