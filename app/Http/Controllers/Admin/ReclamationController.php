<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller {
    public function index() {
        $reclamations = Reclamation::with('user')->latest()->paginate(15);
        return view('admin.reclamations.index', compact('reclamations'));
    }
    public function show(Reclamation $reclamation) {
        return view('admin.reclamations.show', compact('reclamation'));
    }
    public function reply(Request $request, Reclamation $reclamation) {
        $request->validate(['reponce' => 'required|string']);
        $reclamation->update(['reponce' => $request->reponce, 'status' => 'traité']);
        return back()->with('success','Reply sent.');
    }
    public function destroy(Reclamation $reclamation) {
        $reclamation->delete();
        return redirect()->route('admin.reclamations.index')->with('success','Deleted.');
    }
}