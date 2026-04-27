<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
 
class CategorieController extends Controller {
    public function __construct() {
        $this->middleware('permission:category-list',   ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit',   ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        $q = Categorie::withCount('tickets');
        if ($request->search) $q->where('name','like',"%{$request->search}%");
        $categories = $q->latest()->paginate(15)->withQueryString();
        return view('admin.categories.index', compact('categories'));
    }
    public function create() { return view('admin.categories.create'); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:255','description'=>'nullable']);
        Categorie::create($request->only('name','description'));
        return redirect()->route('admin.categories.index')->with('success','Category created.');
    }
    public function edit(Categorie $category) { return view('admin.categories.edit', compact('category')); }
    public function update(Request $request, Categorie $category) {
        $request->validate(['name'=>'required|string|max:255','description'=>'nullable']);
        $category->update($request->only('name','description'));
        return redirect()->route('admin.categories.index')->with('success','Category updated.');
    }
    public function destroy(Categorie $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success','Deleted.');
    }
}