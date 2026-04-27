<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
 
class UserController extends Controller {
    public function __construct() {
        $this->middleware('permission:user-list',   ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        $q = User::with('roles');
        
        // Group the search query to prevent it from bypassing the status/role filters
        if ($request->search) {
            $q->where(function($query) use ($request) {
                $query->where('name','like',"%{$request->search}%")
                      ->orWhere('email','like',"%{$request->search}%");
            });
        }
        
        if ($request->role)        $q->where('type_client',$request->role);
        if ($request->type_client) $q->where('type_client',$request->type_client);
        if ($request->status)      $q->where('status',$request->status);
        
        // Dynamic Sorting logic
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        if (in_array($sortBy, ['name', 'email', 'created_at'])) {
            $q->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }
        
        $users = $q->paginate(15)->withQueryString();
        $totalUsers = User::count();
        $activeUsersCount = User::where('status', 'active')->count();
        $newUsersCount = User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsersCount', 'newUsersCount'));
    }
    public function create() {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create', compact('roles'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'=>'required','email'=>'required|email|unique:users',
            'password'=>'required|min:8|confirmed',
            'roles'=>'required|array','type_client'=>'required|in:admin,employee,client',
            'status'=>'required|in:active,inactive',
            'phone'=>'nullable','cin'=>'nullable','salaire'=>'nullable|numeric',
            'type_contrat'=>'nullable','addresse'=>'nullable','ville'=>'nullable',
            'fichier_de_contrat'=>'nullable|file|max:10240',
        ]);
        if ($request->hasFile('fichier_de_contrat')) {
            $data['fichier_de_contrat'] = $request->file('fichier_de_contrat')->store('contracts', 'public');
        }
        $user = User::create(array_merge($data, ['password' => Hash::make($data['password'])]));
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')->with('success','User created.');
    }
    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }
    public function edit(User $user) {
        $roles    = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit', compact('user','roles','userRole'));
    }
    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name'=>'required','email'=>'required|email|unique:users,email,'.$user->id,
            'roles'=>'required|array','type_client'=>'required|in:admin,employee,client',
            'status'=>'required|in:active,inactive',
            'phone'=>'nullable','cin'=>'nullable','salaire'=>'nullable|numeric',
            'type_contrat'=>'nullable','addresse'=>'nullable','ville'=>'nullable',
            'fichier_de_contrat'=>'nullable|file|max:10240',
        ]);
        if ($request->hasFile('fichier_de_contrat')) {
            $data['fichier_de_contrat'] = $request->file('fichier_de_contrat')->store('contracts', 'public');
        }
        if ($request->filled('password')) {
            $request->validate(['password'=>'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}